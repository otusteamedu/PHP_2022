<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use masteritua\Socket\Server;

try {
    $app = new Server();
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}