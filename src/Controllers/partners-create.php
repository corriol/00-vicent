<?php declare(strict_types=1);?>
<?php require 'src/Entity/Partner.php' ?>
<?php require 'src/Database.php' ?>
<?php require 'src/Model/PartnerModel.php' ?>
<?php
$isGetMethod = true;
$errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $isGetMethod = false;
    //var_dump($_FILES);

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (empty($name)) {
        $errors[] = "The name is mandatory";
    }

    if ($_FILES['logo']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "The logo is mandatory";
    }
    else {
        $filename = $_FILES['logo']['name'];
        $tempPath = $_FILES['logo']['tmp_name'];

        if (!file_exists(Partner::PARTNER_PATH)) {
            mkdir(Partner::PARTNER_PATH, 0777, true);
            if (file_exists(Partner::PARTNER_PATH)) {
                if (move_uploaded_file($tempPath, PARTNER_PATH . "/" . $filename)) {
                    //echo "Archivo guardado con exito";
                } else {
                    $errors[] = "File cannot be saved!";
                }
            }
        } else {
            if (move_uploaded_file($tempPath, Partner::PARTNER_PATH . "/" . $filename)) {
                // echo "Archivo guardado con exito";
            } else {
                $errors[] = "File cannot be saved!";
            }
        }
    }

    if (empty($errors)) {
        try {
            $pdo = Database::getConnection();

            $partner = new Partner();
            $partner->setName($name);
            $partner->setLogo($filename);

            $partnerModel = new PartnerModel($pdo);
            $partnerModel->save($partner);


        } catch(Exception $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }

    }

}

require 'views/partners-create.view.php';

