<?php

namespace Redis\App\Core;

use Elastic\App\Controller\ChannelController;
use Elastic\App\Controller\InfoController;
use Elastic\App\Controller\VideoController;
use Exception;
use Redis\App\Controller\EventController;
use Redis\App\Controller\IndexController;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

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
