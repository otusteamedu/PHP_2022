<?php

namespace Redis\App\Core;

use Exception;
use Redis\App\Controller\EventController;
use Redis\App\Trait\ContainerFactory;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\ResponseEmitter;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    use ContainerFactory;

    public function run(): void
    {
        try {
            $this->configure();

            $app = AppFactory::create();
            $app->map(['POST'], '/event/add', EventController::class . ':add');
            $app->map(['POST'], '/event/delete', EventController::class . ':delete');
            $app->map(['POST'], '/event/get', EventController::class . ':get');

            $app->run();
        } catch (Exception $e) {
            $this->createErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    private function createErrorResponse(string $message, int $code): void
    {
        try {
            $response = $this->getContainer()->get(Response::class);
            $response->getBody()->write(' Error: ' . $message);

            $responseEmitter = $this->getContainer()->get(ResponseEmitter::class);
            $responseEmitter->emit($response->withStatus($code));
        } catch (Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }

    private function configure(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load($_SERVER['DOCUMENT_ROOT'].'/.env');
    }
}
