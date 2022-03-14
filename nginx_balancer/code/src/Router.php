<?php

declare(strict_types=1);
namespace Mapaxa\BalancerApp;

class Router
{
    const CONTROLLERS = 'Mapaxa\BalancerApp\Controller\\';
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }


    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);

                $controllerName = array_shift($segments).'Controller';

                $controllerName = ucfirst($controllerName);
                $actionName = ucfirst(array_shift($segments));

                $controllerFile = ROOT . '/src/Controller/'.$controllerName.'.php';
                if (file_exists($controllerFile )) {
                    include_once ($controllerFile);
                }

                $controllerObjectFullPath = self::CONTROLLERS.$controllerName;
                $controllerObject = new $controllerObjectFullPath;
                $result = $controllerObject->$actionName();
                if ($result != null) {
                    break;
                }
            }
        }
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI']);
        }
        return $uri;
    }
}