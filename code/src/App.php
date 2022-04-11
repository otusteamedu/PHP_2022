<?php

namespace KonstantinDmitrienko\App;

use KonstantinDmitrienko\App\Controllers\AddYoutubeChannelController;
use KonstantinDmitrienko\App\Controllers\AppController;
use KonstantinDmitrienko\App\Controllers\GetAllChannelsController;
use KonstantinDmitrienko\App\Controllers\GetTopRatedChannelsController;
use KonstantinDmitrienko\App\Controllers\HomeController;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;

/**
 * Base app class
 */
class App
{
    /**
     * @var AppController
     */
    protected AppController $controller;

    public function __construct() {
        $this->controller = new AppController();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);

        $router  = new Router;
        $router->map('GET', '/', HomeController::class);
        $router->map('POST', '/add-channel', AddYoutubeChannelController::class);
        $router->map('GET', '/get-all-channels', GetAllChannelsController::class);
        $router->map('GET', '/get-top-rated-channels', GetTopRatedChannelsController::class);

        $response = $router->dispatch($request);

        (new SapiEmitter)->emit($response);
    }
}
