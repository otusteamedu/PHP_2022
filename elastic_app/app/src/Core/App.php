<?php

namespace Elastic\App\Core;

use Elastic\App\Controller\ChannelController;
use Elastic\App\Controller\InfoController;
use Elastic\App\Controller\VideoController;
use Exception;
use Slim\Factory\AppFactory;

class App
{
    public function run(): void
    {
        try {
            $app = AppFactory::create();
            $app->map(['POST'], '/channel/create', ChannelController::class . ':create');
            $app->map(['GET'], '/channel/get', ChannelController::class . ':get');
            $app->map(['GET'], '/channel/delete', ChannelController::class . ':delete');
            $app->map(['POST'], '/video/create', VideoController::class . ':create');
            $app->map(['GET'], '/video/get', VideoController::class . ':get');
            $app->map(['GET'], '/video/delete', VideoController::class . ':delete');
            $app->map(['GET'], '/info/getChannelLikes', InfoController::class . ':getChannelLikes');
            $app->map(['GET'], '/info/getTopChannels', InfoController::class . ':getTopChannels');
            $app->run();
        } catch (Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }
}