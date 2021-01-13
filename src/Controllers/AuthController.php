<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Controller;
use App\Core\Router;
use App\Model\UserModel;

class AuthController extends Controller
{
    public function login()
    {
        $message = App::get('flash')->get("message", "");
        return $this->response->renderView('auth/login', 'default', compact('message'));
    }

    public function checkLogin()
    {
        $messages = [];
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if (!empty($username) && !empty($password)) {
            $userModel = App::getModel(UserModel::class);
            $user = $userModel->findOneBy(["username"=>$username]);
            if (!empty($user)) {
                if ($password == $user->getPassword()) {
                    $_SESSION["loggedUser"] = $user->getId();
                    App::get('flash')->set("message", "S'ha iniciat sessió");
                    App::get(Router::class)->redirect("movies");
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