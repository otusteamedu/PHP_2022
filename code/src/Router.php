<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5;

use Nikcrazy37\Hw5\Exception\AppException;
use Nikcrazy37\Hw5\Exception\ControllerException;
use Nikcrazy37\Hw5\Exception\FileNotFoundException;

class Router
{
    private $routes;
    const controllerNamespace = 'Nikcrazy37\Hw5\Controller\\';

    /**
     * @throws FileNotFoundException
     * @throws AppException
     */
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

                try {
                    $controllerObject = new $controllerObjectPath;
                    $result = $controllerObject->$actionName();

                    if ($result != null) {
                        break;
                    }
                } catch (ControllerException $e) {
                    throw new AppException($e->getMessage(), 400, $e);
                }
            }
        }
    }

    /**
     * @return void
     * @throws FileNotFoundException
     */
    private function includeRoutes()
    {
        $routesPath = ROOT . '/config/routes.php';
        if (!file_exists($routesPath)) {
            throw new FileNotFoundException();
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