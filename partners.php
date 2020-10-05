<?php
require 'inc/partners.php';

$title = "Partners - Movie FX";
function filtar_array(array $array, string $text): array
{
    $array = array_filter($array, function ($v) use ($text) {
        if (stripos($v["name"], $text) !== false)
            return true;
        else
            return false;
    });

    return $array;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["text"])) {
        $partners = filtar_array($partners, htmlspecialchars($_POST["text"]));
    } else
        $error = "Cal introduir una paraula de búsqueda";
}

require 'views/partners.view.php';

