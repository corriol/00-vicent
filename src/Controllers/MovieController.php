<?php
declare(strict_types=1);

namespace App\Controllers;


use App\Core\Controller;
use App\Core\Exception\ModelException;
use App\Database;
use App\Entity\Movie;
use App\Model\GenreModel;
use App\Model\MovieModel;
use App\Core\App;
use DateTime;
use Exception;
use PDOException;

class MovieController extends Controller
{
    public function index():string {
        $title = "Movies - Movie FX";
        $errors = [];
        $movieModel = new MovieModel(App::get("DB"));
        $movies = $movieModel->findAll();

        $order = filter_input(INPUT_GET, "order", FILTER_SANITIZE_STRING);

        if (!empty($_GET['order'])) {
            $orderBy = [$_GET["order"] => $_GET["tipo"]];
            try {
                $movies = $movieModel->findAll($orderBy);
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->response->renderView("movies", "default", compact('title', 'movies',
            'movieModel', 'errors'));
    }

    public function filter(): string {
        // S'executa amb el POST

        $title = "Movies - Movie FX";
        $errors = [];

        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);

        $tipo_busqueda = filter_input(INPUT_POST, "optradio", FILTER_SANITIZE_STRING);

        if (!empty($text)) {
            $pdo=App::get("DB");
            $movieModel = new MovieModel($pdo);
            if ($tipo_busqueda == "both") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE title LIKE :text OR tagline LIKE :text",
                    ["text"=>"%$text%"]);

            }
            if ($tipo_busqueda == "title") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE title LIKE :text",
                    ["text"=>"%$text%"]);

            }
            if ($tipo_busqueda == "tagline") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE tagline LIKE :text",
                    ["text"=>"%$text%"]);

            }

        } else {
            $error = "Cal introduir una paraula de búsqueda";

        }
        return $this->response->renderView("movies", "default", compact('title', 'movies',
            'movieModel', 'errors'));
    }

    public function create(): string {
        $isGetMethod = true;
        $errors = [];
        $pdo = Database::getConnection();
        $genreModel = new GenreModel($pdo);
        $genres = $genreModel->findAll(["name"=>"ASC"]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isGetMethod = false;
            //var_dump($_FILES);
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $overview = filter_input(INPUT_POST, "overview", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tagline = filter_input(INPUT_POST, "tagline", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre_id = filter_input(INPUT_POST, "genre_id", FILTER_VALIDATE_INT);

            if (empty($title)) {
                $errors[] = "The name is mandatory";
            }
            if (empty($overview)) {
                $errors[] = "The overview is mandatory";
            }

            $releaseDate = DateTime::createFromFormat("Y-m-d", $_POST["release_date"]);
            if (empty($releaseDate)) {
                $errors[] = "The release date is mandatory";
            }

            if ($_FILES['poster']['error'] === UPLOAD_ERR_NO_FILE) {
                $errors[] = "The poster is mandatory";
            } else {

                $filename = $_FILES['poster']['name'];
                $tempPath = $_FILES['poster']['tmp_name'];

                if (!file_exists(Movie::POSTER_PATH)) {
                    mkdir(Movie::POSTER_PATH, 0777, true);
                    if (file_exists(Movie::POSTER_PATH)) {
                        if (move_uploaded_file($tempPath, Movie::POSTER_PATH . '/' . $filename)) {
                            // echo "Archivo guardado con exito";
                        } else {
                            $errors[] = "File cannot be saved!";
                        }
                    }
                } else {
                    if (move_uploaded_file($tempPath, Movie::POSTER_PATH . '/' . $filename)) {
                        // echo "Archivo guardado con exito";
                    } else {
                        $errors[] = "File cannot be saved!";
                    }
                }
            }

            if (empty($errors)) {
                try {
                    $movieModel = new MovieModel($pdo);
                    $movie = new Movie();

                    $movie->setTitle($title);
                    $movie->setOverview($overview);
                    $movie->setReleaseDate($releaseDate);
                    $movie->setTagline($tagline);
                    $movie->setPoster($filename);
                    $movie->setGenreId($genre_id);

                    $movieModel->saveTransaction($movie);


                } catch (PDOException | ModelException $e) {
                    $errors[] = "Error: " . $e->getMessage();
                    $pdo->rollBack();
                } catch (Exception $e) {
                    $errors[] = "Error: " . $e->getMessage();
                }
            }
        }
        return $this->response->renderView("movies-create", "default", compact("isGetMethod",
            "errors", "genres"));
    }
}