<?php declare(strict_types=1);

namespace Queen\App;

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Queen\App\Core\Http\HttpRequest;
use Queen\App\Core\Http\HttpResponse;
use function FastRoute\simpleDispatcher;

$injector = include('Dependencies.php');

$request = new HttpRequest($_GET, $_POST, $_SERVER);
$response = new HttpResponse();

$routeDefinitionCallback = function (RouteCollector $r) {
    $routes = include('Core/Routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = simpleDispatcher($routeDefinitionCallback);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        echo $response->getContent();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405  - Method not allowed');
        $response->setStatusCode(405);
        echo $response->getContent();
        break;
    case Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        $class = $injector->make($className);
        $class->$method($vars);
        break;
}
