<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Core\Router;
use App\Model\GenreModel;
use App\Model\MovieModel;
use App\Model\PartnerModel;
use Exception;
use PDOException;
use App\Entity\Movie;

class DefaultController extends Controller
{
    public function index(): string {
        try {
            $movieModel = App::getModel(MovieModel::class);
            $movies = $movieModel->findAllPaginated(1, 8,
                ["release_date"=>"DESC", "title"=>"ASC"]);

            $partnerModel = App::getModel(PartnerModel::class);
            $partners = $partnerModel->findAll();

            $genreModel = App::getModel(GenreModel::class);
            $genres = $genreModel->findAll(["name"=>"ASC"]);


        } catch (PDOException $PDOException) {
            echo $PDOException->getMessage();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        shuffle($partners);
        $partners = array_slice($partners, 0, 4);
        $title = "Movie FX";

        $router = App::get(Router::class);

        $partnersPath = App::get("config")["partners_path"];

        return $this->response->renderView("index", "default", compact('title', 'partners',
            'movies', 'genres', 'router', 'partnersPath'));
    }

    public function contact() {

// 2. S'ha enviat el formulari
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 3. Validar
            if (empty($_POST['nom'])) {
                $errors[] = "No has posat el nom i cognom";
            } else {
                $nom = trim($_POST['nom']);
                $nom = htmlspecialchars($nom);
            }

            if (empty($_POST['data'])) {
                $errors[] = "No has posat la data";
            } else {
                $data = trim($_POST['data']);
                $data = htmlspecialchars($data);
            }

            if (empty($_POST['email'])) {
                $errors[] = "No has posat el correu";
            } else {
                $email = trim($_POST['email']);
                $email = htmlspecialchars($email);
            }

            if (empty($_POST['assumpte'])) {
                $errors[] = "No has posat l'assumpte";
            } else {
                $assumpte = trim($_POST['assumpte']);
                $assumpte = htmlspecialchars($assumpte);
            }

            if (empty($_POST['missatge'])) {
                $errors[] = "No has posat el missatge";
            } else {
                $missatge = trim($_POST['missatge']);
                $missatge = htmlspecialchars($missatge);
            }

        }
        require 'views/contact.view.php';
    }

    public function demo(): string {
        $movieModel = App::getModel(MovieModel::class);
        $movies = $movieModel->findAllPaginated(1, 8,
            ["release_date"=>"DESC", "title"=>"ASC"]);
        return $this->response->jsonResponse($movies);

    }
}