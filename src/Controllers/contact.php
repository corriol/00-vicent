<?php
// 2. S'ha enviat el formulari
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 3. Validar
    if (empty($_POST['nom'])) {
        $errors[] = "No has posat el nom i cognom";
    } else {
        $nom = trim($_POST['nom']);
        $nom = htmlspecialchars($nom);
    }

    if (empty($_POST['data'])) {
        $errors[]= "No has posat la data";
    } else {
        $data = trim($_POST['data']);
        $data = htmlspecialchars($data);
    }

    if (empty($_POST['email'])) {
        $errors[]= "No has posat el correu";
    } else {
        $email = trim($_POST['email']);
        $email = htmlspecialchars($email);
    }

    if (empty($_POST['assumpte'])) {
        $errors[]= "No has posat l'assumpte";
    } else {
        $assumpte = trim($_POST['assumpte']);
        $assumpte = htmlspecialchars($assumpte);
    }

    if (empty($_POST['missatge'])) {
        $errors[]="No has posat el missatge";
    } else {
        $missatge = trim($_POST['missatge']);
        $missatge = htmlspecialchars($missatge);
    }

}
require 'views/contact.view.php';