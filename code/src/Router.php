<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw4;

class Router
{
    private $routes;
    const controllerNamespace = 'Nikcrazy37\Hw4\Controller\\';

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);

                $controllerName = ucfirst(array_shift($segments)) . 'Controller';

                $actionName = ucfirst(array_shift($segments));

                $controllerObjectPath = self::controllerNamespace . $controllerName;

                $controllerObject = new $controllerObjectPath;

                $result = $controllerObject->$actionName();

                if ($result != null) {
                    break;
                }
            }
        }
    }
}