<?php

namespace Dmitry\App\Core;

use Dmitry\App\Controllers\HomeController;

class Application
{

    public function __construct()
    {
        Route::get('/', [HomeController::class, 'index']);
        Route::post('/', [HomeController::class, 'check']);
    }

    public function run(): void
    {
        $request = new Request();
        $route = Route::find($request);

        if ($route) {
            session_start();

            $response = $route($request);
        } else {
            $response = Response::make('Страница не найдена')->withStatus(404);
        }

        $response();
    }
}