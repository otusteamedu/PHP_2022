<?php

declare(strict_types=1);

namespace Kogarkov\Es\App;

use Kogarkov\Es\Config\Config;
use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Core\Service\Request;

class App
{
    public function __construct()
    {
        Registry::instance()->set('config', new Config());
        Registry::instance()->set('request', new Request());
    }

    public function run(): void
    {
        $router = new Router();
        $router->run();
    }
}
