<?php

namespace App;

use App\Http\Controller;
use App\Http\ExceptionHandler;
use App\Http\Response;

class App
{
    public function handle(): void
    {
        try {
            // по факту тут должен вызываться роутер, но чтобы лишнего не пилить
            // вызовем сразу контроллер
            $response = (new Controller())->handle();

            $response->send();
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 400);
            $response->send();
        }
    }
}
