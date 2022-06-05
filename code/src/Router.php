<?php
declare(strict_types=1);

namespace Roman\Hw5;

class Router
{
    private string $uri;

    public function __construct()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $this->uri = trim($_SERVER['REQUEST_URI']);
        }
    }

    public function run(): void
    {
        $matches=explode('/', $this->uri);
        $controllerName = 'Roman\Hw5\Controllers\\' . $matches[1] . 'controller';
        if(!class_exists($controllerName)) {
            $controllerName = 'Roman\Hw5\Controllers\NotFoundController';
        }
        $controller = new $controllerName;
        $controller->run();
    }

}