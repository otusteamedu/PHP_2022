<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12;

use Nikcrazy37\Hw12\Core\Exception\AppException;
use Nikcrazy37\Hw12\Core\Router;

class App
{
    /**
     * @var Router
     */
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * @return void
     * @throws AppException
     */
    public function run(): void
    {
        $this->router->execute();
    }
}