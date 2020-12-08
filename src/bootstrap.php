<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\App;
use App\Core\Response;
use App\Database;


App::bind("DB", Database::getConnection());
App::bind(Response::class, new Response());

