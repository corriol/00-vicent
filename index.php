<?php
declare(strict_types=1);
require 'src/Entity/Partner.php';
require 'src/Entity/Movie.php';
require 'src/Database.php';
require 'inc/functions.php';
require 'src/Model/MovieModel.php';
require 'src/Model/PartnerModel.php';

try {
    $pdo = Database::getConnection();

    $movieModel = new MovieModel($pdo);
    $movies = $movieModel->findAll(["release_date"=>"DESC", "title"=>"ASC"]);

    $partnerModel = new PartnerModel($pdo);
    $partners = $partnerModel->findAll();

} catch (PDOException $PDOException) {
    echo $PDOException->getMessage();
} catch (Exception $exception) {
    echo $exception->getMessage();
}


shuffle($partners);
$partners = array_slice($partners, 0, 4);
$title = "Movie FX";
require 'views/index.view.php';


