<?php

require_once '../vendor/autoload.php';

use Otus\HW6\App;

try {
    $app = new App($argv[1]);
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}