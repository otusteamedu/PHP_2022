<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Service;

class Action
{
    private $id;
    private $route;
    private $method = 'index';

    public function __construct($route)
    {
        $this->id = $route;

        $parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));
        
        // Break apart the route
        while ($parts) {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/src/App/Controller/' . implode('/', $parts) . 'Controller.php';

            if (is_file($file)) {
                $this->route = implode('/', $parts);

                break;
            } else {
                $this->method = array_pop($parts);
            }
        }
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function execute($registry, array $args = array()): mixed
    {
        if (!$this->route) {
            throw new \Exception('Error: Route is not allowed');
        }

        // Stop any magical methods being called
        if (substr($this->method, 0, 2) == '__') {
            throw new \Exception('Error: Calls to magic methods are not allowed!');
        }

        $file = $_SERVER['DOCUMENT_ROOT'] . '/src/App/Controller/' . ucfirst($this->route) . 'Controller.php';
        $class = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst($this->route)) . 'Controller';

        // Initialize the class
        if (is_file($file)) {
            require_once($file);
            $controller = new $class($registry);
        } else {
            throw new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }

        $reflection = new \ReflectionClass($class);

        if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
            return call_user_func_array(array($controller, $this->method), $args);
        } else {
            throw new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
        }
    }
}
