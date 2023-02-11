<?php

namespace app\components;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;

class SlimApplication {
    private App $app;
    public function __construct() {
        $this->app = AppFactory::create();
        $this->app->addErrorMiddleware(true, true, true);
        $this->addRoutes();
    }

    private function addRoutes(): void {
        $routes = require('../config/routes.php');

        foreach ($routes as $route) {
            $this->app->{$route['method']}(
                $route['path'],
                $route['controller'].':'.$route['controllerMethod']
            );
        }
    }

    public function run():void {
        $this->app->run();
    }
}
