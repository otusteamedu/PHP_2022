<?php

declare(strict_types=1);

use Bramus\Router\Router;

$router = new Router();

$router->get(pattern: '/', fn: function () {
    echo 'Otus HomeWork #11 (for lesson #13) - REDIS';
});

$router->post(pattern: '/api/event/add', fn: '\App\Src\Controllers\ApiController@addEvent');
$router->post(pattern: '/api/event/get', fn: '\App\Src\Controllers\ApiController@getConcreteEvent');
$router->post(pattern: '/api/event/get_all', fn: '\App\Src\Controllers\ApiController@getAllEvents');
$router->post(pattern: '/api/event/delete', fn: '\App\Src\Controllers\ApiController@deleteConcreteEvent');
$router->post(pattern: '/api/event/delete_all', fn: '\App\Src\Controllers\ApiController@deleteAllEvents');

$router->set404(function () {
    header(header: 'HTTP/1.1 404 Not Found');
    echo '404';
});

$router->run();
