<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    $requestStatus = new \Svatel\Code\Infrastructure\RequestStatus();
    $app = new \Svatel\Code\Gateway\ApiGateway($requestStatus);
    $app->run();
} catch (Exception $e) {
}