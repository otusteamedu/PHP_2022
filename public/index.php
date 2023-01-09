<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
$config = require '../config/app.php';

$app = new \App\App();

// Добавляем мидлвары из конфига
$middlewares = $config['middleware'] ?? [];
foreach ($middlewares as $middleware) {
    $app->add(new $middleware());
}

$request = \App\Infrastructure\Http\ServerRequest::createFromGlobals();
$app->run($request);