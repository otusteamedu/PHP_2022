<?php

declare(strict_types=1);

use VeraAdzhieva\Hw10\App;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}