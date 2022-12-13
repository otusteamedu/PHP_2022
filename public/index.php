<?php

require_once '../vendor/autoload.php';

$app = new \Dkozlov\Otus\Application();

try {
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
}