<?php

namespace Anosovm\HW5;

class Router
{
    public const DEFAULT_CONTROLLER = 'Anosovm\HW5\Controlles\Controller';

    public function __construct(
        private ?string $uri = null
    ) {
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->uri = $_SERVER['REQUEST_URI'];
        }
    }

    public function run(): void
    {
        $controllerName = explode('/', $this->uri)[1];

        $controller = $this->getControllerByName($controllerName);

        (new $controller)->view();
    }

    private function getControllerByName(string $controllerName)
    {
        $controllerPath = 'Anosovm\HW5\Controllers\\' . $controllerName . 'Controller';

        return class_exists($controllerPath) ? $controllerPath : self::DEFAULT_CONTROLLER;
    }
}