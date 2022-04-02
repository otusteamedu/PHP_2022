<?php

namespace App;

use App\Http\Controller;
use App\Http\ExceptionHandler;
use App\Http\Response;

class App
{
    private ExceptionHandler $handler;

    public function __construct()
    {
        $this->handler = new ExceptionHandler();
    }

    public function handle(): Response
    {
        // по факту тут должен вызываться роутер, но чтобы лишнего не пилить
        // вызовем сразу контроллер
        return (new Controller())->handle();
    }
}
