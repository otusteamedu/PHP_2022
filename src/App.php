<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns;

use Eliasjump\HwStoragePatterns\Controllers\MainPageController;
use Eliasjump\HwStoragePatterns\Controllers\UsersController;
use Eliasjump\HwStoragePatterns\Kernel\Config;
use Eliasjump\HwStoragePatterns\Kernel\Router;

class App
{
    public Router $router;

    public function __construct()
    {
        Config::getInstance()->load();
        $this->router = new Router();
    }

    public function run(): void
    {
        $this->router->get('/', [MainPageController::class, 'run']);

        $this->router->get('/users', [UsersController::class, 'index']);
        $this->router->post('/users/create', [UsersController::class, 'create']);
        $this->router->get('/users/show', [UsersController::class, 'read']);
        $this->router->post('/users/update', [UsersController::class, 'update']);
        $this->router->post('/users/delete', [UsersController::class, 'delete']);

        echo $this->router->resolve();
    }
}
