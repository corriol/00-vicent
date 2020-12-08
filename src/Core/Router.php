<?php

namespace App\Core;

class Router
{
    private array $routes;

    public function setRoutes(array $routes){
        $this->routes = $routes;
    }

    public function get(string $path, string $controller, string $action): void {
        // movies -> [ MovieController, index() ]
        $this->routes["GET"][$path]=["controller"=>$controller, "action"=>$action];
    }

    public function post(string $path, string $controller, string $action): void {
        $this->routes["POST"][$path]=["controller"=>$controller, "action"=>$action];
    }

    public function route(string $url, string $method): string {
        if (array_key_exists($url, $this->routes[$method])) {
            $data = $this->routes[$method][$url];
            $class = "\\App\\Controllers\\" . $data["controller"];
            $instance = new $class;
            $action = $data["action"];
            return call_user_func_array([$instance, $action], []);
        }
        else
            die("The path doesn't exist");
    }
}