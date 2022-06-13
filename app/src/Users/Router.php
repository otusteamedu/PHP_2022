<?php

namespace Katya\App\Users;


class Router
{
    public static function start($routes = 'routes.php') {

        $method = $_SERVER['REQUEST_METHOD']; // POST
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0]; // /registration

        $routes = require_once '../settings/' . $routes;

        foreach ($routes as $route){
            if ($route['path'] === $uri && $route['method'] === $method) {
                $controller = explode("::", $route['controller'])[0];
                $action = explode("::", $route['controller'])[1];
                $obj = new $controller();
                $obj->$action();
                return;
            }
        }
        echo 'что-то пошло не так';
    }
}