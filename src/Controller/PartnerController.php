<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Controller;
use App\Core\Router;
use App\Database;
use App\Entity\Partner;
use App\Exception\UploadedFileException;
use App\Exception\UploadedFileNoFileException;
<<<<<<< HEAD
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
=======
use App\Model\UserModel;
use App\Utils\MyLogger;
use App\Utils\UploadedFile;
use Exception;
use PDO;

class UserController extends Controller
{
    function index(): string
    {
        $title = "Users";

        $userModel = App::getModel(UserModel::class);

        $users = $userModel->findAll(["username" => "ASC"]);
        return $this->response->renderView("users/index", "admin",
            compact('users'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
    }

    function filter(): string
    {
<<<<<<< HEAD
        $title = "Partners";
        $partners = [];
        $partnerModel = App::getModel(PartnerModel::class);
=======
        $title = "Partners - Movie FX";
        $partners = [];
        $partnerModel = App::getModel(PartnerModel::class);
        $router = App::get(Router::class);
        $partnersPath = App::get("config")["partners_path"];
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
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
<<<<<<< HEAD
        return $this->response->renderView("partners", "admin",
            compact('title', 'partners'));
=======
        return $this->response->renderView("partners", "default",
            compact('title', 'partners', 'router', 'partnersPath'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
    }

    /**
     * Shows the creation form
     * @throws Exception
     */
    public function create(): string
    {
<<<<<<< HEAD
        $title = "New partner";
        return $this->response->renderView("partners-create", "admin", compact('title'));
=======
        $title = "New partner - Movie FX";
        return $this->response->renderView("partners-create", "default", compact('title'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
    }

    public function store(): string
    {
        $errors = [];
<<<<<<< HEAD
        $title = "New partner";
        $filename = "nofoto.jpg";

        $partnerModel = App::getModel(PartnerModel::class);

        $partner = $partnerModel->loadData($_REQUEST);

        $errors = $partnerModel->validate($partner);
=======
        $title = "New Partner";
        $filename = "nofoto.jpg";

        $name = filter_input(INPUT_POST, "name");
        if (empty($name)) {
            $errors[] = "The name is mandatory";
        }
>>>>>>> 146d23b85006288681382f395542c8798ef76e87

        // if there are errors we don't upload image file
        if (empty($errors)) {
            try {
<<<<<<< HEAD
                $uploadedFile = new UploadedFile("logo", self::LOGO_MAX_SIZE);
=======
                $uploadedFile = new UploadedFile("logo", 300*1000);
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
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
<<<<<<< HEAD
        // if after uploading the logo we don't have errors
=======
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
        if (empty($errors)) {
            try {
                $partner = new Partner();
                $partner->setName($name);
                $partner->setLogo($filename);

                $partnerModel = App::getModel(PartnerModel::class);
<<<<<<< HEAD
                //throw new Exception("fake exception");

                if ($partnerModel->save($partner)) {
                    App::get("flash")->set("message", "The partner {$partner->getName()} has been created successfully!");
                    App::get(Router::class)->redirect("admin/partners");
=======
                if ($partnerModel->save($partner)) {
                    App::get("flash")->set("message", "The partner {$partner->getName()} has been created successfully!");
                    App::get(Router::class)->redirect("partners");
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
                }

            } catch (Exception $e) {
                $errors[] = 'Error: ' . $e->getMessage();
<<<<<<< HEAD
                // if there are a database error we delete the imatge
                unlink($directory . $filename);
            }
        }
        return $this->response->renderView("partners-store", "admin", compact('errors', 'title'));
=======
            }
        }
        return $this->response->renderView("partners-store", "default", compact('errors', 'title'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
    }

    public function delete(int $id): string
    {
<<<<<<< HEAD
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
=======
        $errors = [];
        $partnerModel = App::getModel(PartnerModel::class);
        $title = "Partner delete - Movie FX";
        $partner = $partnerModel->find($id);
        $router = App::get(Router::class);
        $partnersPath = App::get("config")["partners_path"];

        return $this->response->renderView("partners-delete", "default",
            compact('title', 'partner', 'errors', 'router', 'partnersPath'));
    }


    public function destroy(): string
    {
        $errors = [];
        $title = "Partner delete - Movie FX";
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
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
<<<<<<< HEAD
        else {
            $router->redirectByName('partners_index');
            //$router->redirect('admin/partners');
        }

        return $this->response->renderView("partners-destroy", "admin",
            compact('title', 'partner', 'errors', 'partnersPath'));
=======
        else
            $router->redirect('partners');

        return $this->response->renderView("partners-destroy", "default",
            compact('title', 'partner', 'errors', 'router', 'partnersPath'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
    }

    /**
     * Shows the edit form
     * @param int $id
     * @return string
     * @throws Exception
     */
    public function edit(int $id): string
    {
<<<<<<< HEAD
        $title = "Edit partner";
=======
        $title = "Edit partner - Movie FX";
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
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
<<<<<<< HEAD

        return $this->response->renderView("partners-edit", "default", compact('title',
            'partner'));
=======
        $router = App::get(Router::class);

        return $this->response->renderView("partners-edit", "default", compact('title',
            'partner', 'router'));
>>>>>>> 146d23b85006288681382f395542c8798ef76e87

    }

    public function update(int $id): string
    {
        $errors = [];

<<<<<<< HEAD
        // we get the id from a hidden input if not fail
=======
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
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

<<<<<<< HEAD

=======
>>>>>>> 146d23b85006288681382f395542c8798ef76e87
}