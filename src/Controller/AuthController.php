<?php


namespace App\Controller;


use App\Core\App;
use App\Core\Controller;
use App\Core\Router;
use App\Core\Security;
use App\Model\UserModel;

class AuthController extends Controller
{
    public function login(): string
    {
<<<<<<< HEAD:src/Controller/AuthController.php
        return $this->renderView('auth/login', 'default');
=======
        return $this->response->renderView('auth/login', 'default');
>>>>>>> 146d23b85006288681382f395542c8798ef76e87:src/Controllers/AuthController.php
    }

    public function checkLogin(): void
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if (!empty($username) && !empty($password)) {
            $userModel = App::getModel(UserModel::class);
            $user = $userModel->findOneBy(["username"=>$username]);
            if (!empty($user)) {
                if (Security::checkPassword($password, $user->getPassword() )) {
                    $_SESSION["loggedUser"] = $user->getId();
                    App::get('flash')->set("message", "S'ha iniciat sessió");
                    if ($user->getRole() === "ROLE_ADMIN") {
                        App::get(Router::class)->redirect("admin/movies");
                    }
                    App::get(Router::class)->redirect("");
                }
            }
        }
        App::get('flash')->set("message", "No s'ha pogut iniciar sessió");
        App::get(Router::class)->redirect("login");
    }

    public function logout()
    {
        session_unset();
        unset($_SESSION);
        session_destroy();
        App::get(Router::class)->redirect("");
    }
}