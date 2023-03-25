<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core;

use Kogarkov\Es\Core\Config\Config;
use Kogarkov\Es\Core\Router\Router;
use Kogarkov\Es\Core\Service\Registry;
use Kogarkov\Es\Core\Http\HttpRequest;
use Kogarkov\Es\Core\Http\HttpResponse;

class App
{
    public function __construct()
    {
        Registry::instance()->set('config', new Config());
        Registry::instance()->set('request', new HttpRequest());
        Registry::instance()->set('response', new HttpResponse());
    }

    public function run(): void
    {
        $router = new Router();
        $router->run();
    }
}
