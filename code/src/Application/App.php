<?php

namespace Ppro\Hw28\Application;

use DI\Bridge\Slim\Bridge;
use Slim\App as SlimApp;

class App
{
    protected SlimApp $app;

    /**
     * @return void
     */
    public function run()
    {
        $this->init();
        $this->setMiddleware();
        $this->setRoutes();
        $this->app->run();
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function init()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->addDefinitions(__DIR__ . '/Settings.php');

        $container = $builder->build();
        $this->app = Bridge::create($container);
    }

    /**
     * @return void
     */
    protected function setRoutes()
    {
        $this->app = Routes::setRoutes($this->app);
    }

    /**
     * @return void
     */
    protected function setMiddleware()
    {
        $middleware = require __DIR__ . '/Middleware.php';
        $middleware($this->app);
    }

}