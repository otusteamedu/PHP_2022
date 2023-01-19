<?php

/**
 * Starting point
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Cookapp\Php\Infrastructure\Application;

try {
    $app = new Application();
    $app->run();
} catch (Throwable $exception) {
    echo 'Error: ' . $exception->getMessage() . PHP_EOL;
}
