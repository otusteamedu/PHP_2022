#!/usr/bin/env php
<?php

use Src\Application\Kernel;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new Kernel();

try {
    $kernel->runAmqpConsumer();
} catch (Exception $exception) {
    var_dump(value: 'Exception: ' . $exception->getMessage() . PHP_EOL . 'Trace:' . $exception->getTraceAsString());
    die();
}
