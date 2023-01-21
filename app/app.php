<?php

require_once '../vendor/autoload.php';

try {
    $app = new \Dkozlov\Otus\Application($argv);

    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}