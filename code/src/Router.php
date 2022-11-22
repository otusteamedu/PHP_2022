<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5;

class Router
{
    private $routes;
    const controllerNamespace = 'Nikcrazy37\Hw5\Controller\\';

    public function __construct()
    {
        $this->includeRoutes();
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

    /**
     * @return void
     */
    private function includeRoutes()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * @return string|void
     */
    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
}