<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis;

use Eliasjump\HwRedis\Controllers\EventsController;
use Eliasjump\HwRedis\Controllers\MainPageController;
use Eliasjump\HwRedis\Kernel\Router;

class App
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        $this->router->get('/', [MainPageController::class, 'run']);

        $this->router->post('/events/create', [EventsController::class, 'create']);
        $this->router->post('/events/truncate', [EventsController::class, 'truncate']);
        $this->router->post('/events/show', [EventsController::class, 'show']);

        echo $this->router->resolve();
    }
}
