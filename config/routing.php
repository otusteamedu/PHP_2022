<?php

use App\Infrastructure\Http\Controller\BankAccount\StatisticController;
use Bitty\Http\Response;
use Bitty\Router\RouteCollection;
use Bitty\Router\RouteMatcher;
use Bitty\Router\Router;
use Bitty\Router\UriGenerator;
use Psr\Http\Message\ServerRequestInterface;

$domain    = $_ENV['DOMAIN'];
$routes    = new RouteCollection();
$matcher   = new RouteMatcher($routes);
$generator = new UriGenerator($routes, $domain);

$router = new Router($routes, $matcher, $generator);

$router->add('GET', '/', function (ServerRequestInterface $request) {
    return new Response('Hello, world!');
});

$router->add(['POST', 'GET'], '/bank-account/statistics/generate', StatisticController::class.':generate');

return $router;