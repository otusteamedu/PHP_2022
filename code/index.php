<?php
namespace App;

use Exception;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Server();
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}