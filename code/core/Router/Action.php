<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Router;

class Action
{
    private $route;
    private $method;

    public function __construct(string $route)
    {
        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

        $file = $_SERVER['DOCUMENT_ROOT'] . '/src/' . ucfirst($parts[0]) . '/Infrastructure/Http/' . ucfirst($parts[0]) . 'Controller.php';

        if (is_file($file)) {
            $this->route = $parts[0];
            $this->method = $parts[1];
        } else {
            throw new \Exception('Error: Route is not valid');            
        }
    }

    public function execute()
    {
        if (!$this->route) {
            throw new \Exception('Error: Route is not allowed');
        }

        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            throw new \Exception('Error: Calls to magic methods are not allowed!');
        }

        $file = $_SERVER['DOCUMENT_ROOT'] . '/src/' . ucfirst($this->route) . '/Infrastructure/Http/' . ucfirst($this->route) . 'Controller.php';
        // $class = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst($this->route)) . 'Controller';
        $class='Kogarkov\Es\User\Infrastructure\Http\\'.ucfirst($this->route) . 'Controller';

        // Initialize the class
        if (is_file($file)) {
            require_once($file);
            $controller = new $class();
        } else {
            throw new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }

        $reflection = new \ReflectionClass($class);

        if ($reflection->hasMethod($this->method)) {
            return call_user_func_array([$controller, $this->method], []);
        } else {
            throw new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }
}
