<?php

require_once '../vendor/autoload.php';

$app = new \DKozlov\Otus\Application();

try {
    $app->run();
} catch (Throwable $exception) {
    echo $exception->getMessage() . ' on line ' . $exception->getLine() . ' in file ' . $exception->getFile() . PHP_EOL;
}