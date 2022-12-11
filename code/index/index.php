<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Otus\App\App;

define('APP_DIR', dirname(__DIR__) . '/src');

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . "\n" . "Trace: " . $e->getTraceAsString() . "\n";
}
