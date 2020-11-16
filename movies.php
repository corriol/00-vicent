<?php
declare(strict_types=1);
require 'src/Entity/Movie.php';
require 'src/Model/MovieModel.php';
require 'inc/functions.php';
require_once 'src/Database.php';
$title = "Movies - Movie FX";

$errors = [];


$pdo = new PDO("mysql:host=localhost;dbname=movies", "dbuser", "1234");

//POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);
    $tipo_busqueda = filter_input(INPUT_POST, "optradio", FILTER_SANITIZE_STRING);
    if (!empty($_POST["text"])) {
        if ($tipo_busqueda == "both") {
            $stmt = $pdo->prepare("SELECT * FROM movie WHERE title LIKE :text OR tagline LIKE :text");
            $stmt->bindValue("text", "%$text%", PDO::PARAM_STR);
            $stmt->execute();

        }
        if ($tipo_busqueda == "title") {
            $stmt = $pdo->prepare("SELECT * FROM movie WHERE title LIKE :text");
            $stmt->bindValue("text", "%$text%", PDO::PARAM_STR);
            $stmt->execute();

        }
        if ($tipo_busqueda == "tagline") {
            $stmt = $pdo->prepare("SELECT * FROM movie WHERE tagline LIKE :text");
            $stmt->bindValue("text", "%$text%", PDO::PARAM_STR);
            $stmt->execute();
        }
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Movie::class);
        $movies = $stmt->fetchAll();

    } else {
        $error = "Cal introduir una paraula de búsqueda";
    }
} else {
    $stmt = $pdo->query("SELECT * FROM movie");
    $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Movie::class);
    $movies = $stmt->fetchAll();

    $order = filter_input(INPUT_GET, "order", FILTER_SANITIZE_STRING);
    //Ordenar


    $movieModel = new MovieModel(Database::getConnection());
    if (!empty($_GET['order'])) {
        $orderBy = [$_GET["order"]=>$_GET["tipo"]];
        try {
            $movies = $movieModel->findAll($orderBy);
        } catch (Exception $e) {
            $errors[] = $e->getMessage() ;
        }
    }

    //var_dump($errors);

}


require 'views/movies.view.php';


/**
 * //Validad
 * function validate_form(): array
 * {
 * //Arrays per a emmagatzemar errors o no
 * $inputs = [];
 * $errors = [];
 *
 * //Comprobar nom
 * if (!empty($_POST['titulo'])) {
 * $titulo = trim(htmlspecialchars($_POST['titulo']));
 * $inputs["titulo"] = $titulo;
 * } else {
 * $errors["titulo"] = "El nom és obligatori";
 * }
 * //Comprobar tagline
 * if (!empty($_POST['tagline'])) {
 * $tagline = trim(htmlspecialchars($_POST['tagline']));
 * $inputs["tagline"] = $tagline;
 * } else {
 * $errors["tagline"] = "El tagline és obligatori";
 * }
 * //Comprobar poster
 * $nombre = $_FILES['poster']['name'];
 * $guardado = $_FILES['poster']['tmp_name'];
 * if (!file_exists('posters')) {
 * mkdir('archivos', 0777, true);
 * if (file_exists('posters')) {
 * if (move_uploaded_file($guardado, 'posters/' . $nombre)) {
 * echo "Archivo guardado con existo";
 * } else {
 * echo "Archivo no se puedo guardar";
 * }
 * }
 * } else {
 * if (file_exists('posters')) {
 * if (move_uploaded_file($guardado, 'posters/' . $nombre)) {
 * echo "";
 * $inputs["poster"] = $nombre;
 * } else {
 * echo "Archivo no se puedo guardar";
 * }
 * }
 * }
 *
 * //Comprobar fecha
 * if (!empty($_POST['fecha'])) {
 * $dt1 = DateTime::createFromFormat('Y-m-d', $_POST['fecha']);
 * echo $_POST['fecha'];
 * if ($dt1 === false) {
 * $errors["fecha"] = "El fecha és incorrecta";
 * } else {
 * $inputs["fecha"] = htmlspecialchars($_POST['fecha']);
 *
 * }
 * } else {
 * $errors["fecha"] = "El fecha és obligatori";
 * }
 *
 * return [$inputs, $errors];
 * }
 **/

/**
 * function filtar_array(array $array, string $text): array
 * {
 * $array = array_filter($array, function ($v) use ($text) {
 * if ($_POST["optradio"] == "title") {
 * if (stripos($v->getTitle(), trim($text)) !== false) {
 * return true;
 * } else {
 * return false;
 * }
 * }
 * if ($_POST["optradio"] == "tagline") {
 * if (stripos($v->getTagline(), trim($text)) !== false) {
 * return true;
 * } else {
 * return false;
 * }
 * }
 * if ($_POST["optradio"] == "both") {
 * if (stripos($v->getTitle(), trim($text)) !== false || stripos($v->getTagline(), trim($text)) !== false) {
 * return true;
 * } else {
 * return false;
 * }
 * }
 * });
 * return $array;
 * }
 **/
/**
 * if (!empty($_GET['order'])):
 * if ($_GET['order'] == "title") {
 * if ($_GET['tipo'] == "ASC") {
 * function cmp($a, $b)
 * {
 * if ($a->getTitle() == $b->getTitle()) {
 * return 0;
 * }
 * return ($a->getTitle() < $b->getTitle()) ? -1 : 1;
 * }
 *
 * usort($movies, "cmp");
 * } else {
 * function cmp($a, $b)
 * {
 * if ($a->getTitle() == $b->getTitle()) {
 * return 0;
 * }
 * return ($a->getTitle() > $b->getTitle()) ? -1 : 1;
 * }
 *
 * usort($movies, "cmp");
 * }
 * }
 * if ($_GET['order'] == "release_date") {
 * if ($_GET['tipo'] == "ASC") {
 * function cmp($a, $b)
 * {
 * if ($a->getReleaseDate() == $b->getReleaseDate()) {
 * return 0;
 * }
 * return ($a->getReleaseDate() < $b->getReleaseDate()) ? -1 : 1;
 * }
 *
 * usort($movies, "cmp");
 * } else {
 * function cmp($a, $b)
 * {
 * if ($a->getReleaseDate() == $b->getReleaseDate()) {
 * return 0;
 * }
 * return ($a->getReleaseDate() > $b->getReleaseDate()) ? -1 : 1;
 * }
 *
 * usort($movies, "cmp");
 * }
 * }
 * endif;
 **/


/**
 * //Ordenar peliculas
 * if (!empty($_GET['order'])):
 * if ($_GET['order'] == "title" || $_GET['order'] == "release_date"):
 * foreach ($array_movies as $clave => $fila):
 * $order[$clave] = $fila[$_GET['order']];
 * endforeach;
 * if ($_GET['tipo'] == 'ASC')
 * array_multisort($order, SORT_ASC, $array_movies);
 * else
 * array_multisort($order, SORT_DESC, $array_movies);
 * endif;
 * endif;
 **/

