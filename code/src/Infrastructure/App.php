<?php

namespace Study\Cinema\Infrastructure;


use Study\Cinema\Application\Helper\DotEnv;


class App
{
    public function run()
    {
        (new DotEnv(__DIR__ . '/../../.env'))->load();
        $router = new RoutManager();
       // $pdo = (new DBConnection())->getConnection();


    }
}
