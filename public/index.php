<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$app = new \App\App();

// Добавляем миддлвару, которая проверяет корректность поля со скобками
$app->add(new \App\App\Middleware\ValidateStringFieldMiddleware());
$app->add(new \App\App\Middleware\TestServicesMiddleware());

$request = \App\Infrastructure\Http\ServerRequest::createFromGlobals();
$app->run($request);