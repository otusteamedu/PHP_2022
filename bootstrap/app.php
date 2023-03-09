<?php

// Инициализация приложения
use Bitty\Router\CallbackBuilder;
use Bitty\Router\RouteHandler;

$config = require '../config/app.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();

$router = require '../config/routing.php';

$bindings = require __DIR__ . '/../config/di.php';
$container = new \App\Infrastructure\DI\Container();
foreach ($bindings as $interface => $binding) {
    $container->set($interface, $binding);
}

$handler = new RouteHandler(
    $router,
    new CallbackBuilder($container)
);

return new \App\App($handler);
