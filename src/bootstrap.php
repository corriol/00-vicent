<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Response;
use App\Database;
use App\Utils\MyLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$config = require_once __DIR__ . '/../config/config.php';
App::bind("config", $config);

App::bind("DB", Database::getConnection());
App::bind(Response::class, new Response());

$myLogger = new MyLogger("app");

$myLogger->pushHandler(new StreamHandler(__DIR__."/../{$config["logfile"]}", $config["loglevel"]));

App::bind(MyLogger::class, $myLogger);
