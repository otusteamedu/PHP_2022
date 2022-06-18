<?php

namespace Patterns\App\Infrastructure\Http\Route;

use Slim\App;
use WS\Utils\Collections\CollectionFactory;

class Router
{
    public static function init(App $app): void
    {
        $routes = include $_ENV['PWD']. '/' . $_ENV['routes'];
        CollectionFactory::from($routes)
            ->stream()
            ->each(function (array $route) use ($app) {
                $app->map(['GET', 'POST'], $route['url'], $route['controller'] . ':' . $route['action']);
            });
    }
}
