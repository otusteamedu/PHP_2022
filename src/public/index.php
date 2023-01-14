<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = (require __DIR__ . '/../config/app.php')();

try {
    $app->run();
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getCode(), "\n";
}
