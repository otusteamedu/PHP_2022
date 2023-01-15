<?php

namespace Otus\Task11\Core\Routing;

use Otus\Task11\Core\Http\Request;
use Otus\Task11\Core\Routing\Contrcts\RouterManagerContract;
use Otus\Task11\Core\Routing\RouteCollection;

class RouterManager implements RouterManagerContract
{
    private ?RouteCollection $routers;


    public function __construct( ){
        $this->routers = new RouteCollection();
    }

    public function get($path, $handler): void
    {
        $this->addRoute(new Route('GET', $path, $handler));
    }

    private function addRoute(Route $route): void
    {
        $this->routers->add($route);
    }

    public function resolve(Request $request) : Route{

        foreach ($this->routers as $route){
            return $route;
        }
    }
}