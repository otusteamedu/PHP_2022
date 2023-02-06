<?php

namespace Study\Cinema\Infrastructure;


use Study\Cinema\Infrastructure\RoutManager;
use Study\Cinema\Application\Helper\DotEnv;


class App
{
    public function __construct()
    {
    }
    public function run()
    {

        (new DotEnv(__DIR__ . '/../../.env'))->load();
        $router = new RoutManager();





    }

}
