<?php

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() {
    echo 'About Page Contents';
});

$router->get('/test', function() {
    echo 'About Test Contents';
});

$router->set404(function() {
    header(header: 'HTTP/1.1 404 Not Found');
    echo '404';
});

$router->run();
