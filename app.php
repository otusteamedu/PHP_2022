<?php

use Dkozlov\App\App;

require_once 'vendor/autoload.php';

try {
    $app = new App($argv[1]);

    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}