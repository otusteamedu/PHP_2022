<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp;

use Mapaxa\EmailVerificationApp\Dto\Track;
use Mapaxa\EmailVerificationApp\Exception\RoutesFileException;
use Mapaxa\EmailVerificationApp\Service\Renderer\Renderer;

class Router
{
    const CONTROLLERS = 'Mapaxa\EmailVerificationApp\Controller\\';
    private $routes;

    public function __construct()
    {
        $routesPath = 'config/routes.php';
        if (!is_readable($routesPath)) {
            throw new RoutesFileException();
        }
        $this->routes = include($routesPath);
    }


    private function getTrack()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $segments = explode('/', $path);
                $controllerName = array_shift($segments).'Controller';

                $controllerName = ucfirst($controllerName);
                $actionName = array_shift($segments);

                return new Track($controllerName , $actionName);

                if ($result != null) {
                    return $result;
                }
            }

        }
        if (!isset($controllerObject)) {
            return new Track('PageNotFoundController' , 'index');
        }

    }


    public function run():void
    {
        $track = $this->getTrack();
        $controllerObjectFullPath = self::CONTROLLERS.$track->controller;

        $controllerObject = new $controllerObjectFullPath();
        $action = $track->action;
        $result = $controllerObject->$action();
    }

    private function getUri(): string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = trim($_SERVER['REQUEST_URI']);
        }
        return $uri;
    }
}