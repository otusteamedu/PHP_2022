<?php

namespace Otus\Task13\Core\Http;

use Otus\Task13\Core\Routing\Route;
use Psr\Container\ContainerInterface;

class ControllerResolve
{
    public function __construct(
        private readonly Route              $route,
        private readonly ContainerInterface $container)
    {
    }

    public function make()
    {
        $handler = $this->route->getHandler();

        if (is_array($handler)) {
            [$class, $method] = $handler;
            if ($this->container->has($class)) {
                $class = $this->container->get($class);
                return call_user_func_array([$class, $method], []);
            }
        }

        if (is_string($handler) && class_exists($handler)) {
            if ($this->container->has($handler)) {
                $class = $this->container->get($handler);
                return call_user_func_array([$class, '__invoke'], []);
            }
        }
    }
}