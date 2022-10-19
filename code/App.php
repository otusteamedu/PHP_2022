<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Nikolai\Php\Infrastructure\Application;

try {
    $app = new Application();
    $app->run();
} catch (Throwable $exception) {
    echo 'Исключение: ' . $exception->getMessage() . PHP_EOL;
}

/*
try {
    $dsn = "pgsql:host=postgresql;port=5432;dbname=cinema;user=user;password=password";
    $pdo = new PDO($dsn);

    var_dump($pdo);
} catch (Throwable $exception) {
    echo 'Исключение: ' . $exception->getMessage();
}

print_r(PDO::getAvailableDrivers());
*/