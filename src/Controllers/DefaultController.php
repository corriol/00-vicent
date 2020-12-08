<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
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
            $pdo = App::get("DB");

            $movieModel = new MovieModel($pdo);
            $movies = $movieModel->findAll(["release_date"=>"DESC", "title"=>"ASC"]);

            $partnerModel = new PartnerModel($pdo);
            $partners = $partnerModel->findAll();

            $genreModel = new GenreModel($pdo);
            $genres = $genreModel->findAll(["name"=>"ASC"]);


        } catch (PDOException $PDOException) {
            echo $PDOException->getMessage();
        } catch (Exception $exception) {
            echo $exception->getMessage();
        }


        shuffle($partners);
        $partners = array_slice($partners, 0, 4);
        $title = "Movie FX";

        return $this->response->renderView("index", "default", compact('title', 'partners',
            'movies', 'genres'));
    }
}