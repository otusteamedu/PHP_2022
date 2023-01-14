<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HW10\App\App;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
