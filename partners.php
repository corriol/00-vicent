<?php declare(strict_types = 1); ?>

<?php require "src/Entity/Partner.php" ?>
<?php require "src/Database.php" ?>

<?php
$title = "Partners - Movie FX";

$pdo = Database::getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["text"])) {
        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);

        $stmt = $pdo->prepare("SELECT * FROM partner WHERE name LIKE :text");
        $stmt->bindValue("text", "%$text%", PDO::PARAM_STR);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, Partner::class);
        $partners = $stmt->fetchAll();
    } else
        $error = "Cal introduir una paraula de búsqueda";
} else
{
    $stmt = $pdo->query("SELECT * FROM partner");
    $stmt->setFetchMode(PDO::FETCH_CLASS, Partner::class);
    $partners = $stmt->fetchAll();

}

require 'views/partners.view.php';

