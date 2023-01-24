<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../config/');
$dotenv->Load();
        
    return [
        'driver' => $_ENV['DRIVER'],
        'host' => $_ENV['HOST'],
        'port' => $_ENV['MYSQL_PORT'],
        'db' => $_ENV['MYSQL_DATABASE'],
        # for doctrine
        'dbname' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_ROOT'],
        'password' => $_ENV['MYSQL_ROOT_PASSWORD']
    ];
