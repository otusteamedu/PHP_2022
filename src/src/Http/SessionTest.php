<?php

declare(strict_types=1);

namespace App\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class SessionTest implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        session_start();

        if (!isset($_SESSION['visit'])) {
            $message = "This is the first time you're visiting this server\n";
            $_SESSION['visit'] = 0;
        } else {
            $message = "Your number of visits: " . $_SESSION['visit'] . "\n";
        }

        $_SESSION['visit']++;

        $response = new Response();

        $response->getBody()->write($message);

        return $response;

    }
}