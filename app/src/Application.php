<?php

declare(strict_types=1);

namespace Eliasjump\StringsVerification;

use Eliasjump\StringsVerification\Controllers\MainPageController;
use Eliasjump\StringsVerification\Controllers\StringController;

final class Application
{
    public Router $router;

    public function __construct()
    {
        session_start();
        !isset($_SESSION['counter']) ? $_SESSION['counter'] = 1 : $_SESSION['counter']++;

        $this->router = new Router();
    }

    public function run(): void
    {
        $this->router->get('/', [MainPageController::class, 'run']);

        $this->router->post('/', [StringController::class, 'run']);

        echo $this->router->resolve();
    }
}
