<?php

use App\Core\App;
use App\Core\Exception\AppException;
use App\Core\Request;
use App\Core\Router;

session_start();

require_once __DIR__ . '/../src/bootstrap.php';

$request = new Request();
$url = $request->getPath();



$router = new Router();
require_once __DIR__ . '/../config/routes.php';


App::bind(Router::class, $router);
try {

    echo $router->route($url, $request->getMethod());
}
catch (AppException $appException){
    echo $appException->handleException();
}

