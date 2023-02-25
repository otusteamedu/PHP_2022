<?php

declare(strict_types=1);

use Src\Application\Kernel;

require_once __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel();

try {
    $kernel->runApplication();
} catch (Exception $exception) {
    var_dump('Exception: ' . $exception->getMessage() . PHP_EOL . 'Trace:' . $exception->getTraceAsString());

    die();
}
