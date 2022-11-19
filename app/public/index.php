<?php

declare(strict_types=1);

use Eliasjump\EmailVerification\Application;
use Eliasjump\EmailVerification\Render;

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = new Application();
    $response = $app->run();
    echo (new Render("", $response))->run();
} catch (Exception $exception) {
    http_response_code(500);
    echo $exception->getMessage();
}
