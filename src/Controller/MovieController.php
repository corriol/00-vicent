<?php
declare(strict_types=1);

namespace App\Controller;


use App\Core\Controller;
use App\Core\Exception\ModelException;
use App\Core\Exception\NotFoundException;
use App\Core\Router;
use App\Core\Security;
use App\Entity\Movie;
use App\Exception\UploadedFileException;
use App\Exception\UploadedFileNoFileException;
use App\Model\GenreModel;
use App\Model\MovieModel;
use App\Core\App;
use App\Utils\MyLogger;
use App\Utils\UploadedFile;
use DateTime;
use Exception;
use PDOException;

/**
 * Class MovieController
 * @package App\Controller
 */
class MovieController extends Controller
{
    const POSTER_MAX_SIZE = 3000*1024; //3000KB

    /**
     * @return string
     * @throws Exception
     */
    public function index(): string
    {
        $title = "Movies - Movie FX";

        $errors = [];
        $movieModel = App::getModel(MovieModel::class);
        $movies = $movieModel->findAll();


        if (!empty($_GET['order'])) {
            $orderBy = [$_GET["order"] => $_GET["tipo"]];
            try {
                $movies = $movieModel->findAll($orderBy);
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $this->renderView("movies", "admin", compact('title', 'movies',
            'movieModel', 'errors'));
    }

    /**
     * @return string
     * @throws ModelException
     */
    public function filter(): string
    {
        // S'executa amb el POST
        $title = "Movies - Movie FX";
        $errors = [];
        $movieModel = null;
        $movies = null;

        $router = App::get(Router::class);

        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);

        $tipo_busqueda = filter_input(INPUT_POST, "optradio", FILTER_SANITIZE_STRING);

        if (!empty($text)) {
            $movieModel = App::getModel(MovieModel::class);
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

        return $this->renderView("movies", "admin", compact('title', 'movies',
            'movieModel', 'errors', 'router'));
    }


    /**
     * @return string
     * @throws ModelException
     */
    public function search(): string
    {
        // Aquest formulari en gestiona des de diverses pàgines ja que es troba en la capçalera de la web.
        // Sempre renderitzarà la mateixa vista, per això cal assegurar-se que totes les variables i objectes
        // existeixen en qualsevol dels dos possible camins.
        $movies = null;
        $movieModel = null;
        $errors = [];

        $queryText = filter_input(INPUT_GET, "q", FILTER_SANITIZE_SPECIAL_CHARS);

        $title = "Movies search - $queryText";

        if (empty($queryText)) {
            $errors[] = "You must include a query text";
        }
        else {
            $movieModel = App::getModel(MovieModel::class);
            $movies = $movieModel->executeQuery("SELECT * FROM movie WHERE title LIKE :text OR tagline LIKE :text",
                ["text" => "%$queryText%"]);
        }
        return $this->renderView("movies-list", "default", compact('title', 'movies',
            'movieModel', 'errors'));
    }


    /**
     * @return string
     * @throws Exception
     */
    public function create(): string
    {
        $genreModel = App::getModel(GenreModel::class);
        $genres = $genreModel->findAll(["name" => "ASC"]);

        return $this->renderView("movies-create-form", "default", compact("genres"));
    }

    /**
     * @return string
     * @throws Exception
     */
    public function store(): string
    {
        $errors = [];

        $genreModel = App::getModel(GenreModel::class);
        $genres = $genreModel->findAll(["name" => "ASC"]);

        /*$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $overview = filter_input(INPUT_POST, "overview", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tagline = filter_input(INPUT_POST, "tagline", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $genre_id = filter_input(INPUT_POST, "genre_id", FILTER_VALIDATE_INT);
        $filename = "nofoto.jpg";*/

        $movieModel = App::getModel(MovieModel::class);

        $movie = $movieModel->loadData($_POST, new Movie());

        //var_dump($movie);

        $errors = $movieModel->validate($movie);

        // If there are errors we don't need to upload the poster.
        if (empty($errors)) {
            try {
                $uploadedFile = new UploadedFile("poster", self::POSTER_MAX_SIZE, ["image/jpeg", "image/jpg"]);
                if ($uploadedFile->validate()) {
                    $uploadedFile->save(Movie::POSTER_PATH, uniqid("MOV"));
                    $filename = $uploadedFile->getFileName();
                    $movie->setPoster($filename);
                }
            } catch (Exception $exception) {
                $errors[] = "Error uploading file ($exception)";
            }
        }

        if (empty($errors)) {
            try {
                $movieModel = App::get(MovieModel::class);
          /*
                $movie = new Movie();

                $movie->setTitle($title);
                $movie->setOverview($overview);
                $movie->setReleaseDate($releaseDate);
                $movie->setTagline($tagline);
                $movie->setPoster($filename);
                $movie->setGenreId($genre_id);
            */
                $movieModel->saveTransaction($movie);
                App::get(MyLogger::class)->info("S'ha creat una nova pel·lícula");

            } catch (PDOException | ModelException | Exception $e) {
                $errors[] = "Error: " . $e->getMessage();
            }
        }

        if (empty($errors)) {
            App::get(Router::class)->redirect("movies");
        }

        return $this->renderView("movies-create", "default", compact(
            "errors", "genres"));
    }


    /**
     * @param int $id
     * @return string
     * @throws Exception
     */

    public function delete(int $id): string
    {
        $errors = [];
        $movie = null;
        $movieModel = App::getModel(MovieModel::class);

        if (empty($id)) {
            $errors[] = '404 Not Found';
        } else {
            try {
                $movie = $movieModel->find($id);
            } catch (NotFoundException $e) {
                $errors[] = '404 Movie Not Found';
            }
        }

        $router = App::get(Router::class);
        $moviesPath = App::get("config")["posters_path"];

        return $this->renderView("movies-delete", "default", compact(
            "errors", "movie", 'moviesPath', 'router'));
    }

    /**
     * @return string
     * @throws ModelException
     * @throws NotFoundException
     */

    public function destroy(): string
    {
        $errors = [];
        $movieModel = App::getModel(MovieModel::class);
        $movie = null;

        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if (empty($id)) {
            $errors[] = '404 Not Found';
        } else {
            $movie = $movieModel->find($id);
        }
        $userAnswer = filter_input(INPUT_POST, "userAnswer");
        if ($userAnswer === 'yes') {
            if (empty($errors)) {
                try {
                    $movie = $movieModel->find($id);
                    $result = $movieModel->delete($movie);
                } catch (PDOException $e) {
                    $errors[] = "Error: " . $e->getMessage();
                }
            }
        }
        else
            App::get(Router::class)->redirect('movies');

        if (empty($errors))
            App::get(Router::class)->redirect('movies');
        else
            return $this->renderView("movies-destroy", "default",
                compact("errors", "movie"));
    }

    /**
     * @param int $id
     * @return string
     * @throws ModelException
     * @throws NotFoundException
     */

    public function edit(int $id): string
    {
        $isGetMethod = true;
        $errors = [];
        $movieModel = App::getModel(MovieModel::class);
        $genres = App::getModel(GenreModel::class)->findAll(["name"=>"desc"]);
        $movie = null;

        if (empty($id)) {
            $errors[] = '404 Not Found';
        } else {
            $movie = $movieModel->find($id);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isGetMethod = false;

            $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
            if (empty($id))
                throw new NotFoundException();

            $movie = $movieModel->find($id);

            $movie = $movieModel->loadData($_POST, $movie);

            var_dump($movie);
            $errors = $movieModel->validate($movie);

            /*
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

            $poster = filter_input(INPUT_POST, "poster");

            */
            if (empty($errors)) {
                //Gestion de la imagen si se ha subido
                try {
                    $image = new UploadedFile('poster', self::POSTER_MAX_SIZE, ['image/jpg', 'image/jpeg']);
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
                    //$movie = $movieModel->find($id);

                    //then we set the new values
                 /*   $movie->setTitle($title);
                    $movie->setOverview($overview);
                    $movie->setReleaseDate($releaseDate);
                    $movie->setTagline($tagline);
                    $movie->setPoster($poster); */

                    $movieModel->update($movie);

                } catch (PDOException $e) {
                    $errors[] = "Error: " . $e->getMessage();
                }
            }
        }

        return $this->renderView("movies-edit", "default", compact("isGetMethod",
            "errors", "genres", "movie"));
    }

    /**
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function show(int $id): string
    {
        $errors = [];
        if (!empty($id)) {
                $movieModel = new MovieModel(App::get("DB"));
                $movie = $movieModel->find($id);
                $title = $movie->getTitle() . " (" . $movie->getReleaseDateObj()->format("Y") . ") - Movie FX";
                return $this->renderView("single-page", "default", compact(
                    "errors", "movie"));
       }
        else
            return $this->renderView("single-page", "default", compact(
                "errors"));
    }

    /**
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function listByGenre(int $id): string
    {

        $genre = App::getModel(GenreModel::class)->find($id);
        $movies = App::getModel(MovieModel::class)->findBy(["genre_id" => $id]);

        $title = $genre->getName() . " movies";

        return $this->renderView("movies-list", "default", compact('title', 'movies',
            'genre'));
    }

}