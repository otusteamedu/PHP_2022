<?php

namespace Patterns\App;

use Exception;
use Patterns\App\Infrastructure\Http\Route\Router;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response;
use Slim\ResponseEmitter;
use Symfony\Component\Dotenv\Dotenv;

class App
{
    public function run(): void
    {
        try {
            $this->configure();

            $app = AppFactory::create();
            Router::init($app);
            $app->run();
        } catch (Exception $e) {
            $this->createErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    private function createErrorResponse(string $message, int $code): void
    {
        try {
            $response = ContainerFactory::getContainer()->get(Response::class);
            $response->getBody()->write(' Error: ' . $message);

            $responseEmitter = ContainerFactory::getContainer()->get(ResponseEmitter::class);
            $responseEmitter->emit($response->withStatus($code));
        } catch (Exception $e) {
            header('Status: 500 Error: ' . $e->getMessage());
        }
    }

    private function configure(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load($_SERVER['PWD'].'/.env');
    }
}