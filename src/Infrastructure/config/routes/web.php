<?php

declare(strict_types=1);

// phpcs:disable

use Bramus\Router\Router;

$router = new Router();

$router->get(
    pattern: '/',
    fn: '\Src\Infrastructure\Controllers\BankStatementController@index'
);

$router->post(
    pattern: '/bank_statement/generate',
    fn: '\src\Infrastructure\Controllers\BankStatementController@generate'
);

$router->run();
