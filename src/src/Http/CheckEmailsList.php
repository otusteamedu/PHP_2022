<?php

declare(strict_types=1);

namespace App\Http;

use Bundle\CheckEmailBundle\CheckEmailBundle;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class CheckEmailsList implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();

        $response = new Response();

        $emails_list = $params['emails_list'] ?? '';

        $emails_separator = $params['emails_separator'] ?? '';

        if (empty($emails_list) || !is_string($emails_list) || !is_string($emails_separator)) {
            $response->getBody()->write('Wrong parameter');
            return $response->withStatus(400);
        }

        $result = CheckEmailBundle::checkEmailsList($emails_list, $emails_separator);

        $response->getBody()->write($result);

        return $response;
    }
}