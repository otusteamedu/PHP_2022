<?php

namespace Otus\Task13\Core\Routing;

use Otus\Task13\Core\Http\HttpRequest;
use Otus\Task13\Core\Routing\Contrcts\RouterManagerContract;

class RouterManager implements RouterManagerContract
{

    public function __construct(private readonly ?RouteCollection $routers)
    {
    }

    public function get($path, $handler): void
    {
        $this->addRoute(new Route('GET', $path, $handler));
    }

    private function addRoute(Route $route): void
    {
        $this->routers->add($route);
    }

    public function resolve(HttpRequest $request): Route
    {
        foreach ($this->routers as $route) {
            if ($route->getPath() === $request->getUri()) {
                return $route;
            }
        }
    }
}