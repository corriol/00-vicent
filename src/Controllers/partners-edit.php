<?php declare(strict_types=1); ?>
<?php require 'src/Partner.php' ?>

<?php
$isGetMethod = true;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isGetMethod = false;
    //var_dump($_FILES);
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    if (empty($id)) {
        $errors[] = "Wrong ID";
    }

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (empty($name)) {
        $errors[] = "The name is mandatory";
    }

    $filename = filter_input(INPUT_POST, "logo");
    // Gestió de la imatge
    if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
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

            $stmt = $pdo->prepare('UPDATE partner SET name=:name,logo=:logo WHERE id =:id');
            $stmt->bindValue("name", $name, PDO::PARAM_STR);
            $stmt->bindValue("logo", $filename, PDO::PARAM_STR);
            $stmt->bindValue("id", $id, PDO::PARAM_INT);
            $stmt->execute();

            # Affected Rows?
            if ($stmt->rowCount() === 0)
                $errors[] = "No changes detected!";
        } catch (PDOException $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }

    }
}
else
{
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if (empty($id))
        $errors[] = "404 Not found";
}
// 1. Get connection
$pdo = Database::getConnection();

// 2. Prepare query
$stmt = $pdo->prepare('SELECT * FROM partner WHERE id=:id');

// 3. Assign parameters values
$stmt->bindValue("id", $id, PDO::PARAM_INT);

// 4. Execute query
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, Partner::class);

// 5. Get result
$partner = $stmt->fetch();


require 'views/partners-edit.view.php';

