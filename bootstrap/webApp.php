<?php

// Инициализация приложения
use Bitty\Router\CallbackBuilder;
use Bitty\Router\RouteHandler;

$config = require '../config/app.php';
$container = require __DIR__ . '/container.php';

$router = require '../config/routing.php';

$handler = new RouteHandler(
    $router,
    new CallbackBuilder($container)
);

return new \App\App($handler);
