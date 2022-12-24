<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns;

use Eliasjump\HwStoragePatterns\App\Kernel\Config;
use Eliasjump\HwStoragePatterns\App\Kernel\Router;
use Eliasjump\HwStoragePatterns\Modules\Pages\Infrastructure\Controllers\MainPageController;
use Eliasjump\HwStoragePatterns\Modules\Users\Infrastructure\Contollers\UsersController;

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
