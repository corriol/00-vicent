<?php

use Monolog\Logger;


return [
    "database" =>
        [   "connection" => "mysql:host=mysql-server;dbname=movies;charset=utf8",
            "username" => "dbuser",
            "password" => "1234",
            "options" => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true]
        ]
    ,
    "logfile" => "app.log",
    "loglevel" => Logger::DEBUG,
    // les rutes les posem sense la barra inicial perquè les usem en dos àmbits
    // 1. sistema de fitxers: ruta relativa
    // 2. web: url relativa a l'arrel on caldrà posar la barra
    "partners_path" => "images/partners/",
    "posters_path" => "images/posters/",
    'mailer' => [
        'smtp_server' => "smtp.gmail.com",
        'smtp_port' => 587,
        'smtp_security' => 'tls',
        'username' => 'vjorda.pego@gmail.com',
        'password' => 'fakepassword',
        'email' => 'vjorda.pego@gmail.com',
        'name' => 'Vicent Jordà'
    ],
    "security" => ["roles" =>
        [
            "ROLE_ADMIN" => 3,
            "ROLE_USER" => 2,
            "ROLE_ANONYMOUS" => 1
        ]
    ]
];
