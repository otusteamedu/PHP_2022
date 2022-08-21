<?php

declare(strict_types=1);

namespace App\Component\Kernel;

use App\Component\Router\Router;

final class Kernel
{
    private Router $router;

    /**
     * Kernel construct
     */
    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * @return void
     */
    public function initializeApplication(): void
    {
        $this->router->captureRequest();
    }
}
