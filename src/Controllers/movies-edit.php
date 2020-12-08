<?php
declare(strict_types=1);
require 'inc/functions.php';
require 'src/Entity/Movie.php';
require_once __DIR__ . '/./src/Utils/UploadedFile.php';

$isGetMethod = true;
$errors = [];

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
if (empty($id)) {
    $errors[] = '404 Not Found';
} else {

    $pdo = new PDO("mysql:host=localhost;dbname=movies;charset=utf8", "dbuser", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT * FROM movie WHERE id=:id');
    $stmt->bindValue("id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
    $movies = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isGetMethod = false;
    //var_dump($_FILES);
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
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

      //Si no se sube una imagen cogera la que tenemos en el formulario oculta
    $poster = filter_input(INPUT_POST, "poster");
    //Gestion de la imagen si se ha subido
    try {
        $image = new UploadedFile('poster', 300000, ['image/png','image/jpeg']);
        if($image->validate()){
            $image->save(Movie::POSTER_PATH);
            $poster = $image->getFileName();
        }
        //Al estar editando no nos interesa que se muestre este error ya que puede ser que no suba archivo
    }catch (UploadedFileNoFileException $uploadFileNoFileException){
        //$errors[] = $uploadFileNoFileException->getMessage();
    }catch (UploadedFileException $uploadFileException){
        $errors[] = $uploadFileException->getMessage();
    }


    if (empty($errors)) {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=movies;charset=utf8", "dbuser", "1234");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('UPDATE movie SET title=:title, overview=:overview, release_date=:release_date,
                                            tagline=:tagline, poster=:poster WHERE id=:id');
            $stmt->bindValue("title", $title, PDO::PARAM_STR);
            $stmt->bindValue("overview", $overview, PDO::PARAM_STR);
            $stmt->bindValue("release_date", $releaseDate->format("Y-m-d"), PDO::PARAM_STR);
            $stmt->bindValue("tagline", $tagline, PDO::PARAM_STR);
            $stmt->bindValue("poster", $poster, PDO::PARAM_STR);
            $stmt->bindValue("id", $id, PDO::PARAM_INT);
            $stmt->execute();

            # Affected Rows?
            if ($stmt->rowCount() === 0) {
                $errors[] = "No changes detected";
            }
        } catch (PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}

require 'views/movies-edit.view.php';