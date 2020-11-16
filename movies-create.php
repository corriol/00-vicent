<?php
require 'inc/functions.php';
require 'src/Movie.php';

$isGetMethod = true;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isGetMethod = false;
    //var_dump($_FILES);
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $overview = filter_input(INPUT_POST, "overview", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $tagline = filter_input(INPUT_POST, "tagline", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (empty($title)) {
        $errors[] = "The name is mandatory";
    }
    if (empty($overview)) {
        $errors[] = "The overview is mandatory";
    }
    if (empty($_POST["release_date"])) {
        $errors[] = "The release date is mandatory";
    }else{
        $release_date = $_POST["release_date"];
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
            $pdo = new PDO("mysql:host=localhost;dbname=movies;charset=utf8", "dbuser", "1234");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare('INSERT INTO movie(title, overview, release_date, tagline, poster) 
                                VALUES(:title, :overview, :release_date, :tagline, :poster)');
            $stmt->bindValue("title", $title, PDO::PARAM_STR);
            $stmt->bindValue("overview", $overview, PDO::PARAM_STR);
            $stmt->bindValue("release_date", $release_date);
            $stmt->bindValue("tagline", $tagline, PDO::PARAM_STR);
            $stmt->bindValue("poster", $filename, PDO::PARAM_STR);
            $stmt->execute();

            # Affected Rows?
            if ($stmt->rowCount() !== 1) {
                $errors[] = "More then one row affected";
            }
        } catch (PDOException $e) {
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
require 'views/movie-create.view.php';
