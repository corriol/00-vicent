<?php
declare(strict_types=1);


use App\Core\Exception\NotFoundException;
use App\Database;
use App\Model\MovieModel;

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!empty($id)) {
    try {
        $pdo = Database::getConnection();
        $movieModel = new MovieModel($pdo);
        $movie = $movieModel->find($id);
        $title = $movie->getTitle() . " (" . $movie->getReleaseDate()->format("Y") . ") - Movie FX";
    } catch (NotFoundException $notFoundException) {
        $errors[] = $notFoundException->getMessage();
    }
}
require "views/single-page.view.php";



/**
 * try {
 * function filtar_array(array $array, string $text): array
 * {
 * $array = array_filter($array, function ($v) use ($text) {
 *
 * if (stripos(strval($v->getId()), $text) !== false) {
 * return true;
 * } else {
 * return false;
 * }
 *
 * });
 * return $array;
 * }
 *
 * if ($idCorrecto == false)
 * throw new MovieNotFound();
 * $movies = filtar_array($movies, $id);
 *
 * } catch (MovieNotFound $e){
 * $errorException = $e->getMessage();
 * } catch (Exception $e){
 * $errorException = $e->getMessage();
 * }
 **/