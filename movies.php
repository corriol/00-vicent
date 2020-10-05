<?php
require 'inc/movies.php';
require 'inc/functions.php';

$title = "Movies - Movie FX";
function filtar_array(array $array, string $text): array
{
    $array = array_filter($array, function ($v) use ($text) {
        if (stripos($v["title"], trim($text)) !== false || stripos($v["tagline"], trim($text)) !== false) {
            return true;
        } else {
            return false;
        }
    });
    return $array;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["text"])) {
        $films = filtar_array($films, htmlspecialchars($_POST["text"]));
    } else {
        $error = "Cal introduir una paraula de búsqueda";
    }
}
require 'views/movies.view.php';

