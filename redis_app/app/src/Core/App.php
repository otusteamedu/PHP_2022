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
            $responseEmitter = $this->getContainer()->get(ResponseEmitter::class);
            $responseEmitter->emit($this->createErrorResponse($e->getMessage(), $e->getCode()));
        }
    }

    private function createErrorResponse(string $message, int $code): Response
    {
        $response = $this->getContainer()->get(Response::class);
        $response->getBody()->write(' Error: ' . $message);

        return $response->withStatus($code);
    }

    private function configure(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load($_SERVER['DOCUMENT_ROOT'].'/.env');
    }
}
