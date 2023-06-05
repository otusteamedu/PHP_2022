<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16;

use Nikcrazy37\Hw16\Libs\Exception\Base\FileNotFoundException;
use Nikcrazy37\Hw16\Libs\Exception\Base\NotFoundClassException;
use Nikcrazy37\Hw16\Libs\Exception\Base\NotFoundMethodException;

class Router
{
    private array $routes;

    /**
     * @throws NotFoundClassException
     * @throws NotFoundMethodException
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        $this->includeRoutes();
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);

                $moduleName = ucfirst(array_shift($segments));
                $controllerName = $moduleName . 'Controller';
                $controllerNamespace = "Nikcrazy37\Hw16\Modules\\{$moduleName}\Infrastructure\Controller\\";
                $actionName = ucfirst(array_shift($segments));
                $controllerObjectPath = $controllerNamespace . $controllerName;

                if (!class_exists($controllerObjectPath)) {
                    throw new NotFoundClassException($controllerObjectPath);
                }

                if (!method_exists($controllerObjectPath, $actionName)) {
                    throw new NotFoundMethodException($actionName);
                }

                $controllerObject = new $controllerObjectPath;
                $result = $controllerObject->$actionName();

                if ($result !== null) {
                    break;
                }
            }
        }
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    private function includeRoutes(): void
    {
        $routesPath = ROOT . '/src/config/routes.php';
        if (!file_exists($routesPath)) {
            throw new FileNotFoundException($routesPath);
        }

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