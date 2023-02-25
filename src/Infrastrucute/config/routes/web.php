<?php

declare(strict_types=1);

use Bramus\Router\Router;

$router = new Router();

$router->get(pattern: '/', fn: function() {
    echo 'About Page Contents';
});

$router->post(pattern: '/bank_statement/generate', fn: '');

$router->run();
