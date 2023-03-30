<?php

declare(strict_types=1);

namespace Core\Router;

class Router
{
    private $routes;
    private $route;
    private $class_name;
    private $method;
    private $interface_implementaions;

    public function __construct()
    {
        require_once(__DIR__ . '/routes.php');
        require_once(__DIR__ . '/implementations.php');

        $this->routes = $routes;
        $this->interface_implementaions = $interface_implementaions;

        $this->route = $_SERVER['REQUEST_URI'];
    }

    public function run(): void
    {
        $this->parseRoute();
        $this->execute();
    }

    private function parseRoute(): void
    {
        $param_char_pos = strpos((string)$this->route, '?');
        $this->route = substr((string)$this->route, 0, $param_char_pos !== false ? $param_char_pos : strlen($this->route));
        
        if (!isset($this->routes[$this->route])) {
            throw new \Exception('Error: Route is not allowed');
        }

        $this->class_name = $this->routes[$this->route]['class_name'];
        $this->method = $this->routes[$this->route]['method'];
    }

    private function execute()
    {
        $controller = $this->resolve($this->class_name);

        if (method_exists($controller, $this->method)) {
            return call_user_func_array([$controller, $this->method], []);
        } else {
            throw new \Exception('Error: Could not call ' . $this->class_name . '/' . $this->method . '!');
        }
    }

    public function resolve(string $class): object
    {
        $class_reflector = new \ReflectionClass($class);

        if (!$class_reflector->isInstantiable() && $class_reflector->isInterface()) {
            $class = $this->getImplementation($class_reflector);
            $class_reflector = new \ReflectionClass($class);
        }

        $construct_reflector = $class_reflector->getConstructor();
        if (empty($construct_reflector)) {
            return new $class;
        }

        $construct_arguments = $construct_reflector->getParameters();
        if (empty($construct_arguments)) {
            return new $class;
        }

        foreach ($construct_arguments as $argument) {
            $argument_type = $argument->getType()->getName();
            $args[$argument->getName()] = $this->resolve($argument_type);
        }

        return new $class(...$args);
    }

    private function getImplementation(\ReflectionClass $class): string
    {
        if (isset($this->interface_implementaions[$class->getName()])) {
            return $this->interface_implementaions[$class->getName()];
        } else {
            throw new \Exception("Interface implementation of " . $class->getName() . " is not available");
        }
    }
}
