<?php

declare(strict_types=1);

namespace Eliasjump\StringsVerification;

final class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}
