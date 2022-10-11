<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Nikolai\Php\Infrastructure\Application;

try {
    $app = new Application();
    $app->run();
} catch (\Exception $exception) {
    echo 'Исключение: ' . $exception->getMessage();
}
