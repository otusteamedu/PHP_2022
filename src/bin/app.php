#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
