<?php

declare(strict_types=1);
namespace Mapaxa\BalancerApp;

use Mapaxa\BalancerApp\Exception\RoutesFileException;

class Router
{
    const CONTROLLERS = 'Mapaxa\BalancerApp\Controller\\';
    private $routes;

    public function __construct()
    {
        $routesPath = 'config/routes.php';
        if (!is_readable($routesPath)) {
            throw new RoutesFileException();
        }
        $this->routes = include($routesPath);
    }


    public function run(): void
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);
                $controllerName = array_shift($segments).'Controller';

                $controllerName = ucfirst($controllerName);
                $actionName = ucfirst(array_shift($segments));

                $controllerObjectFullPath = self::CONTROLLERS.$controllerName;

                $controllerObject = new $controllerObjectFullPath;

                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }

        }
        if (!isset($controllerObject)) {
            header("Location: /page_not_found");
        }

    }

    private function getUri(): string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI']);
        }
        return $uri;
    }
}