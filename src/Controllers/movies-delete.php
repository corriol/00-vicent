<?php
declare(strict_types=1);
require 'inc/functions.php';
require __DIR__ . '/src/Entity/Movie.php';

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
    if (isset($_POST['yes'])) {
        $isGetMethod = false;
        //var_dump($_FILES);

        if (empty($errors)) {
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=movies;charset=utf8", "dbuser", "1234");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->prepare('DELETE FROM movie WHERE id=:id');
                $stmt->bindValue("id", $id, PDO::PARAM_INT);
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
}

require 'views/movies-delete.view.php';