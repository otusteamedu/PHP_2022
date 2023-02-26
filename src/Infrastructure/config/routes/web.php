<?php

declare(strict_types=1);

use Bramus\Router\Router;

$router = new Router();

$router->get(
    pattern: '/',
    fn: '\Src\Infrastructure\Controllers\BankStatementController@index'
);

$router->post(
    pattern: '/bank-statement/generate',
    fn: '\Src\Infrastructure\Controllers\BankStatementController@generate'
);

$router->run();
