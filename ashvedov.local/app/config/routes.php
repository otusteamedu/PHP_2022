<?php

use Bramus\Router\Router;

$router = new Router();

$router->get(pattern: '/', fn: function() {
    echo 'About Page Contents';
});

$router->get(pattern: '/balancer-work', fn: '\App\Src\Infrastructure\Controllers\NginxBalancerController@showcaseWork');

$router->get(pattern: '/parentheses', fn: '\App\Src\Infrastructure\Controllers\ParenthesesController@show');
$router->post(pattern: '/parentheses/validate', fn: '\App\Src\Infrastructure\Controllers\ParenthesesController@validate');

$router->set404(function() {
    header(header: 'HTTP/1.1 404 Not Found');
    echo '404';
});

$router->run();
