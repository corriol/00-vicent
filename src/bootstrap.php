<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Response;
use App\Database;
use App\Utils\MyLogger;


$config = require_once __DIR__ . '/../config/config.php';
App::bind("config", $config);

App::bind("DB", Database::getConnection());
App::bind(Response::class, new Response());


