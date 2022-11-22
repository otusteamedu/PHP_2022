<?php

declare(strict_types=1);

namespace Otus\App;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use Otus\App\Controller\AddEventController;
use Otus\App\Controller\DeleteEventsController;
use Otus\App\Controller\GetEventsController;
use Otus\App\Viewer\Result;

class App
{
    public function run(): void
    {
        try {
            $request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

            $router = new Router;
            $router->map('GET', '/add-event/{event}', AddEventController::class);
            $router->map('GET', '/get-event/{params}', GetEventsController::class);
            $router->map('GET', '/delete-events/', DeleteEventsController::class);

            $response = $router->dispatch($request);

            (new SapiEmitter)->emit($response);
        } catch (\Exception $e) {
            Result::failure($e->getMessage());
        }
    }

    public static function getConfig()
    {
        return include('Config/config.php');
    }
}
