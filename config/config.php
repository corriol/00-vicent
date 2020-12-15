<?php

use Monolog\Logger;

return [
    "database" =>
        [
            "connection" => "mysql:host=localhost;dbname=movies;charset=utf8",
            "username" => "dbuser",
            "password" => "1234",
            "options" => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true]
        ]
    ,
    "logfile" => "my_app.log",
    "loglevel" => Logger::DEBUG,
    "partners_path" => "images/partners/",
    "posters_path" => "images/posters/"
];
