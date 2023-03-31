<?php

declare(strict_types=1);

namespace Core;

use Core\Config\Config;
use Core\Router\Router;
use Core\Service\Container;

class App
{
    public function __construct()
    {
        Container::instance()->set('config', new Config());
    }

    public function run(): void
    {
        $router = new Router();
        $router->run();
    }
}
