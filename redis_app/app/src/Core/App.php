<?php

namespace Redis\App\Core;

use Exception;
use Redis\App\Controller\EventController;
use Slim\Factory\AppFactory;

class App
{
    public function run(): void
    {
        try {
            $app = AppFactory::create();

            $app->map(['POST'], '/event/add', EventController::class . ':add');
            $app->map(['POST'], '/event/delete', EventController::class . ':delete');
            $app->map(['POST'], '/event/get', EventController::class . ':get');

            $app->run();
        } catch (Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }
}
