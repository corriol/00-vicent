<?php
declare(strict_types=1);

namespace App\Controllers;


use App\Core\Controller;
use App\Core\Exception\ModelException;
use App\Core\Exception\NotFoundException;
use App\Core\Router;

use App\Entity\Movie;
use App\Exception\UploadedFileException;
use App\Exception\UploadedFileNoFileException;
use App\Model\GenreModel;
use App\Model\MovieModel;
use App\Core\App;
use App\Utils\UploadedFile;
use DateTime;
use Exception;
use PDOException;

class MovieController extends Controller
{
    public function index(): string
    {
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
        $router = App::get(Router::class);

        return $this->response->renderView("movies", "default", compact('title', 'movies',
            'movieModel', 'errors', 'router'));
    }

    public function filter(): string
    {
        // S'executa amb el POST

        $title = "Movies - Movie FX";
        $errors = [];

        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);

        $tipo_busqueda = filter_input(INPUT_POST, "optradio", FILTER_SANITIZE_STRING);

        if (!empty($text)) {
            $pdo = App::get("DB");
            $movieModel = new MovieModel($pdo);
            if ($tipo_busqueda == "both") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE title LIKE :text OR tagline LIKE :text",
                    ["text" => "%$text%"]);

            }
            if ($tipo_busqueda == "title") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE title LIKE :text",
                    ["text" => "%$text%"]);

            }
            if ($tipo_busqueda == "tagline") {
                $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE tagline LIKE :text",
                    ["text" => "%$text%"]);

            }

        } else {
            $error = "Cal introduir una paraula de búsqueda";

        }
        return $this->response->renderView("movies", "default", compact('title', 'movies',
            'movieModel', 'errors'));
    }

    public function create(): string
    {
        $genreModel = new GenreModel(App::get("DB"));
        $genres = $genreModel->findAll(["name" => "ASC"]);

        return $this->response->renderView("movies-create-form", "default", compact("genres"));
    }

    public function store(): string
    {
        $errors = [];
        $pdo = App::get("DB");
        $genreModel = new GenreModel($pdo);
        $genres = $genreModel->findAll(["name" => "ASC"]);

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

        // If there are errors we don't need to upload the poster.
        if (empty($errors)) {
            try {
                $uploadedFile = new UploadedFile("poster", 2000 * 1024, ["image/jpeg", "image/jpg"]);
                if ($uploadedFile->validate()) {
                    $uploadedFile->save(Movie::POSTER_PATH, uniqid("MOV"));
                    $filename = $uploadedFile->getFileName();
                }
            } catch (Exception $exception) {
                $errors[] = "Error uploading file ($exception)";
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
            } catch (Exception $e) {
                $errors[] = "Error: " . $e->getMessage();
            }
        }

        if (empty($errors)) {
            App::get(Router::class)->redirect("movies");
        }

        return $this->response->renderView("movies-create", "default", compact(
            "errors", "genres"));
    }

    public function delete()
    {
        $isGetMethod = true;
        $errors = [];
        $movieModel = new MovieModel(App::get("DB"));

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if (empty($id)) {
            $errors[] = '404 Not Found';
        } else {
            $movie = $movieModel->find($id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['yes'])) {
                $isGetMethod = false;

                if (empty($errors)) {
                    try {
                        $movie = $movieModel->find($id);
                        $result = $movieModel->delete($movie);
                    } catch (PDOException $e) {
                        $errors[] = "Error: " . $e->getMessage();
                    }
                }
            }
        }

        return $this->response->renderView("movies-delete", "default", compact("isGetMethod",
            "errors", "movie"));
    }

    public function edit(int $id)
    {
        $isGetMethod = true;
        $errors = [];
        $movieModel = new MovieModel(App::get("DB"));

        if (empty($id)) {
            $errors[] = '404 Not Found';
        } else {
            $movie = $movieModel->find($id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isGetMethod = false;

            $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
            if (empty($id)) {
                $errors[] = "Wrong ID";
            }

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($title)) {
                $errors[] = "The title is mandatory";
            }

            $overview = filter_input(INPUT_POST, "overview", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($overview)) {
                $errors[] = "The overview is mandatory";
            }

            $tagline = filter_input(INPUT_POST, "tagline", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $releaseDate = DateTime::createFromFormat("Y-m-d", $_POST["release_date"]);
            if (empty($releaseDate)) {
                $errors[] = "The release date is mandatory";
            }

            if (empty($errors)) {
                //Si no se sube una imagen cogera la que tenemos en el formulario oculta
                $poster = filter_input(INPUT_POST, "poster");
                //Gestion de la imagen si se ha subido
                try {
                    $image = new UploadedFile('poster', 300000, ['image/jpg', 'image/jpeg']);
                    if ($image->validate()) {
                        $image->save(Movie::POSTER_PATH);
                        $poster = $image->getFileName();
                    }
                    //Al estar editando no nos interesa que se muestre este error ya que puede ser que no suba archivo
                } catch (UploadedFileNoFileException $uploadFileNoFileException) {
                    //$errors[] = $uploadFileNoFileException->getMessage();
                } catch (UploadedFileException $uploadFileException) {
                    $errors[] = $uploadFileException->getMessage();
                }
            }

            if (empty($errors)) {
                try {
                    // Instead of creating a new object we load the current data object.
                    $movie = $movieModel->find($id);

                    //then we set the new values
                    $movie->setTitle($title);
                    $movie->setOverview($overview);
                    $movie->setReleaseDate($releaseDate);
                    $movie->setTagline($tagline);
                    $movie->setPoster($poster);

                    $movieModel->update($movie);

                } catch (PDOException $e) {
                    $errors[] = "Error: " . $e->getMessage();
                }
            }
        }

        return $this->response->renderView("movies-edit", "default", compact("isGetMethod",
            "errors", "movie"));
    }

    public function show(int $id)
    {
        $errors = [];
        if (!empty($id)) {
            try {
                $movieModel = new MovieModel(App::get("DB"));
                $movie = $movieModel->find($id);
                $title = $movie->getTitle() . " (" . $movie->getReleaseDate()->format("Y") . ") - Movie FX";
            } catch (NotFoundException $notFoundException) {
                $errors[] = $notFoundException->getMessage();
            }
        }
        return $this->response->renderView("single-page", "default", compact(
            "errors", "movie"));


    }
}