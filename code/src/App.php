<?php

namespace KonstantinDmitrienko\App;

use KonstantinDmitrienko\App\Controller\AddEventController;
use KonstantinDmitrienko\App\Controller\DeleteEventsController;
use KonstantinDmitrienko\App\Controller\GetEventsController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;

/**
 * Base app class
 */
class App
{
    /**
     * @return void
     */
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
            Response::failure($e->getMessage());
        }
    }
}
