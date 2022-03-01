<?php

declare(strict_types=1);

namespace Philip\Otus\Core;

class App
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->session();
        $this->dispatcher = new Dispatcher;
    }

    public function dispatchRequest(string $key)
    {
        $this->dispatcher->dispatch($key);
    }

    protected function session()
    {
        session_start();
    }
}