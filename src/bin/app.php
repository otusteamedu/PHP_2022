#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
