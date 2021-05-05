<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Controller;
use App\Core\Router;
use App\Database;
use App\Entity\Partner;
use App\Exception\UploadedFileException;
use App\Exception\UploadedFileNoFileException;
use App\Model\PartnerModel;
use App\Utils\MyLogger;
use App\Utils\UploadedFile;
use Exception;
use MongoDB\Driver\Exception\ExecutionTimeoutException;
use PDO;
use PDOException;

class PartnerController extends Controller
{
    private const LOGO_MAX_SIZE = 50000;

    function index(): string
    {
        $title = "Partners";
        $partnerModel = App::getModel(PartnerModel::class);
        $partners = $partnerModel->findAll(["name" => "ASC"]);
        return $this->renderView("partners", "admin",
            compact('partners', 'title'));
    }

    function filter(): string
    {
        $title = "Partners";
        $partners = [];
        $partnerModel = App::getModel(PartnerModel::class);
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_STRING);
            if (!empty($text)) {
                $title = "Partners - Filtered by ($text) - Movie FX";
                $partners = $partnerModel->executeQuery("SELECT * FROM partner WHERE name LIKE :text",
                    ["text" => "%$text%"]);
            } else
                $error = "Cal introduir una paraula de búsqueda";
        } else {
            $partners = $partnerModel->findAll();
        }
        return $this->response->renderView("partners", "admin",
            compact('title', 'partners'));
    }

    /**
     * Shows the creation form
     * @throws Exception
     */
    public function create(): string
    {
        $title = "New partner";
        return $this->response->renderView("partners-create", "admin", compact('title'));
    }

    public function store(): string
    {
        $errors = [];
        $title = "New partner";
        $filename = "nofoto.jpg";

        $partnerModel = App::getModel(PartnerModel::class);

        $partner = $partnerModel->loadData($_REQUEST);

        $errors = $partnerModel->validate($partner);

        // if there are errors we don't upload image file
        if (empty($errors)) {
            try {
                $uploadedFile = new UploadedFile("logo", self::LOGO_MAX_SIZE);
                if ($uploadedFile->validate()) {
                    // we get the path form config file
                    $directory = App::get("config")["partners_path"];
                    // we use uniqid to generate a uniqid filename;
                    $uploadedFile->save($directory, uniqid("PTN"));
                    // we get the generated name to save it in the db
                    $filename = $uploadedFile->getFileName();
                }
            } catch (UploadedFileNoFileException $uploadedFileNoFileException) {
                $errors[] = $uploadedFileNoFileException->getMessage();
            } catch (UploadedFileException | Exception $uploadedFileException ) {
                $errors[] = $uploadedFileException->getMessage();
                App::get(MyLogger::class)->error($uploadedFileException->getMessage());
            }
        }
        // if after uploading the logo we don't have errors
        if (empty($errors)) {
            try {
                $partner = new Partner();
                $partner->setName($name);
                $partner->setLogo($filename);

                $partnerModel = App::getModel(PartnerModel::class);
                //throw new Exception("fake exception");

                if ($partnerModel->save($partner)) {
                    App::get("flash")->set("message", "The partner {$partner->getName()} has been created successfully!");
                    App::get(Router::class)->redirect("admin/partners");
                }

            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
                // if there are a database error we delete the imatge
                unlink($directory . $filename);
            }
        }
        return $this->response->renderView("partners-store", "admin", compact('errors', 'title'));
    }

    public function delete(int $id): string
    {
        $partnerModel = App::getModel(PartnerModel::class);
        $title = "Partner delete";
        $partner = $partnerModel->find($id);

        return $this->response->renderView("partners-delete", "admin",
            compact('title', 'partner'));
    }

    public function destroy(): string
    {
        $errors = [];
        $title = "Partner delete";
        $userAnswer = filter_input(INPUT_POST, "userAnswer");
        $router = App::get(Router::class);
        $partnersPath = App::get("config")["partners_path"];
        $partner = null;

        if (!empty($userAnswer) && $userAnswer == "yes") {
            $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
            $partnerModel = App::getModel(PartnerModel::class);
            $partner = $partnerModel ->find($id);
            if (!$partnerModel->delete($partner))
                $errors[] = "There were errors deleting entity";
        }
        else {
            $router->redirectByName('partners_index');
            //$router->redirect('admin/partners');
        }

        return $this->response->renderView("partners-destroy", "admin",
            compact('title', 'partner', 'errors', 'partnersPath'));
    }

    /**
     * Shows the edit form
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function edit(int $id): string
    {
        $title = "Edit partner";
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

        return $this->response->renderView("partners-edit", "default", compact('title',
            'partner'));

    }

    public function update(int $id): string
    {
        $errors = [];

        // we get the id from a hidden input if not fail
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
        if (empty($id)) {
            $errors[] = "Wrong ID";
        }

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (empty($name)) {
            $errors[] = "The name is mandatory";
        }

        $filename = filter_input(INPUT_POST, "logo");

        // if there are errors we don't upload image file
        if (empty($errors)) {
            try {
                $uploadedFile = new UploadedFile("logo");
                if ($uploadedFile->validate()) {
                    // we get the path form config file
                    $directory = App::get("config")["partners_path"];
                    // we use uniqid to generate a uniqid filename;
                    $uploadedFile->save($directory, uniqid("PTN"));
                    // we get the generated name to save it in the db
                    $filename = $uploadedFile->getFileName();
                }
            } catch (UploadedFileNoFileException $uploadedFileNoFileException) {
                // When updating is possible not to upload a file
            } catch (UploadedFileException $uploadedFileException) {
                $errors[] = $uploadedFileException->getMessage();
            }
        }

        if (empty($errors)) {
            try {
                $partnerModel = App::getModel(PartnerModel::class);
                // getting the partner by its identifier
                $partner = $partnerModel->find($id);
                $partner->setName($name);
                $partner->setLogo($filename);
                // updating changes
                $partnerModel->update($partner);
            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
            }
        }
        return $this->response->renderView("partners-update");
    }


}