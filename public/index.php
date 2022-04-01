<?php

use App\Http\ExceptionHandler;
use App\Http\Response;

require_once './../vendor/autoload.php';

try {
    $app = new \App\App();
    $response = $app->handle();
} catch (\Exception $exception) {
    $handler = new ExceptionHandler();
    $handler->handle($exception);

    $response = new Response($exception->getMessage(), 400);
}

$response->send();
