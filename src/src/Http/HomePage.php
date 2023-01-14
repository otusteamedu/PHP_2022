<?php

declare(strict_types=1);

namespace App\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class HomePage implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $message = 'Hello from ' . $_SERVER['SERVER_NAME'] . '<br>';

        $response->getBody()->write($message);

        return $response;
    }
}