<?php

use App\Core\Request;
use App\Core\Router;

require_once __DIR__ . '/../src/bootstrap.php';

$request = new Request();
$url = $request->getPath();

$router = new Router();
require_once __DIR__ . '/../config/routes.php';
echo $router->route($url, $request->getMethod());

