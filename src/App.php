<?php

namespace App;

use App\Http\Controller;
use App\Http\ExceptionHandler;
use App\Http\Request;
use App\Http\Response;

class App
{
    public function handle(): void
    {
        $request = new Request();

        try {
            $controller = new Controller();
            // по факту тут должен вызываться роутер, но чтобы лишнего не пилить
            // вызовем сразу контроллер
            $response = $controller->handle($request);
        } catch (\Exception $exception) {
            $handler = new ExceptionHandler();
            $handler->handle($exception);

            $response = new Response($exception->getMessage(), 400);
        }

        $response->send();
    }
}
