<?php

namespace Anosovm\HW5;

class App
{
    public function __construct(private ?Router $router = null)
    {
        $this->router = new Router();
    }

    public function run(): void
    {
        $this->router->run();
    }
}