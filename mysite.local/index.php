<?php

declare(strict_types=1);

use Kirillov\App;
use Kirillov\Exception\InvalidMethodException;

require __DIR__ . '/../config/bootstrap.php';

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    http_response_code($exception->getCode());

    echo json_encode([
        'message' => $exception->getMessage(),
        'code' => $exception->getCode()
    ], JSON_PRETTY_PRINT);
}