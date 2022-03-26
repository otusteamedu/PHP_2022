<?php

namespace Elastic\App\Core;

use Elastic\App\Controller\ChannelController;
use Elastic\App\Controller\IndexController;
use Elastic\App\Controller\VideoController;
use Exception;
use Slim\Factory\AppFactory;

class App
{
    public function run(): void
    {
        try {
            $app = AppFactory::create();
            $app->map(['GET'], '/test', IndexController::class . ':index');
            $app->map(['POST'], '/channel/create', ChannelController::class . ':create');
            $app->map(['GET'], '/channel/get', ChannelController::class . ':get');
            $app->map(['GET'], '/channel/delete', ChannelController::class . ':delete');
            $app->map(['POST'], '/video/create', VideoController::class . ':create');
            $app->map(['GET'], '/video/get', VideoController::class . ':get');
            $app->map(['GET'], '/video/delete', VideoController::class . ':delete');
            $app->run();
        } catch (Exception $e) {
            $test = $e->getMessage();
        }
    }
}