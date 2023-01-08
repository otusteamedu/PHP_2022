<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
require_once '../src/functions.php';
$config = require '../config/app.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env');
$dotenv->load();

$bindings = require __DIR__ . '/../config/di.php';
$container = new \App\Infrastructure\DI\Container();
foreach ($bindings as $interface => $binding) {
    $container->set($interface, $binding);
}

$app = new \App\App();

// Добавляем мидлвары из конфига
$middlewares = $config['middleware'] ?? [];
foreach ($middlewares as $middleware) {
    $app->add($container->get($middleware));
}

$request = \App\Infrastructure\Http\ServerRequest::createFromGlobals();
$app->run($request);