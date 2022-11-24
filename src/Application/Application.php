<?php

namespace App\Application;

use Slim\Factory\AppFactory;
use Slim\App;
use App\HTTP\HTTPController;

class Application extends AppFactory
{
    protected App $app;
    public function __construct()
    {
        $this->app = self::create();
    }

    public function run()
    {
        $this->app->addErrorMiddleware(true, true, true);
        $this->app->post('/', [HTTPController::class, 'checkBracesNum']);
        $this->app->run();
    }
}
