<?php

declare(strict_types=1);

$host = (string)getenv('DB_HOST');
$port = (int)getenv('DB_PORT');
$db = (string)getenv('DB_DATABASE');
$user = (string)getenv('DB_USER');
$pass = (string)getenv('DB_PASS');

return [
    'database' => [
        'host' => $host,
        'port' => $port,
        'db' => $db,
        'user' => $user,
        'pass' => $pass,
        'dsn' => sprintf(
            'pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s',
            $host,
            $port,
            $db,
            $user,
            $pass
        )
    ]
];
