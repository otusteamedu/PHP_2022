<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\classes;

use Mselyatin\Project6\src\interfaces\RouteManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * @RouteManager
 * @\Mselyatin\Project6\src\classes\RouteManager
 */
class RouteManager implements RouteManagerInterface
{
    /** @var array  */
    private array $routes;

    /** @var RouteCollection  */
    private RouteCollection $routeCollection;

    /**
     * @param array $routes
     */
    public function __construct(
      array $routes
    ) {
        $this->routes = $routes;
    }

    /**
     * @return void
     */
    public function init(): void
    {
        /** @var Route[] $routes */
        $routes = [];

        foreach ($this->routes as $route) {
            $path = $route['path'] ?? null;
            $class = $route['class'] ?? null;
            $method = $route['method'] ?? null;
            $slag = $route['slag_route'] ?? null;

            if (!$path || !$class || !$method || !$slag) {
                continue;
            }

            $routes[$slag] = new Route($path, [ 'class' => $class, 'method' => $method ]);
        }

        $routesCollection = new RouteCollection();

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());

        foreach ($routes as $slag => $route) {
            $routesCollection->add($slag, $route);
        }

        $this->routeCollection = $routesCollection;
    }

    /**
     * Call controller method
     * @return void
     */
    public function mapping(): void
    {
        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
        $matcher = new UrlMatcher($this->routeCollection, $context);
        $parameters = $matcher->match($context->getPathInfo());

        $class = $parameters['class'];
        $method = $parameters['method'];

        if (class_exists($class) && method_exists($class, $method)) {
            $instance = new $class();
            $instance->$method();
            return;
        }

        throw new \RuntimeException('Mapping is not valid');
    }
}