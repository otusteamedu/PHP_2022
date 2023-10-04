#!/usr/bin/env php
<?php

declare(strict_types=1);

use App\Factory\AppFactory;
use Psr\Container\ContainerExceptionInterface;

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../config/container.php';

$app = AppFactory::create($container);

try {
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
} catch (ContainerExceptionInterface $e) {
    echo $e->getMessage() . PHP_EOL;
}
