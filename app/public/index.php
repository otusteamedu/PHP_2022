<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';


try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $app = new \HW10\App\App();
    //$app->makeIndex();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
