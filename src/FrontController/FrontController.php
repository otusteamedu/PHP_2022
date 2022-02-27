<?php

declare(strict_types=1);

namespace Philip\Otus\FrontController;

class FrontController
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = new Dispatcher;
    }

    public function dispatchRequest()
    {
        $this->dispatcher->dispatch();
    }
}