<?php

declare(strict_types=1);

return [
    'database' => [
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'db' => getenv('DB_DATABASE'),
        'user' => getenv('DB_USER'),
        'pass' => getenv('DB_PASS'),
        'dsn' => sprintf('pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s',
            getenv('DB_HOST'),
            getenv('DB_PORT'),
            getenv('DB_DATABASE'),
            getenv('DB_USER'),
            getenv('DB_PASS'))
    ]
];
