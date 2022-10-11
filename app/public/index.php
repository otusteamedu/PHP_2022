<?php

declare(strict_types=1);

use Nemizar\OtusShop\App;

require __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', dirname(__DIR__) . '/src');

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
