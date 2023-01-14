<?php

declare(strict_types=1);

namespace App\Http;

use Bundle\CheckBracketsBundle\CheckBracketsBundle;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class CheckBrackets implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getParsedBody();

        $response = new Response();

        $str = $params['string'] ?? '';

        if (empty($str) || !is_string($str)) {
            $response->getBody()->write('Wrong parameter');
            return $response->withStatus(400);
        }

        $result = CheckBracketsBundle::areBracketsCorrect($str);

        $response->getBody()->write($result ? 'All correct' : 'All bad');

        return $result ? $response : $response->withStatus(400);
    }
}