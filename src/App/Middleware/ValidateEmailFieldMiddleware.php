<?php

declare(strict_types=1);

namespace App\App\Middleware;

use App\App\Service\EmailVerifier;
use App\App\Service\EmailVerifierMode;
use App\Infrastructure\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Миддлвара, которая проверяет корректность заполнения поля email
 * Требования:
 *  - поле email, если оно есть в запросе, должно быть заполнено корректным email-адресом
 */
class ValidateEmailFieldMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // поле нас интересует только в POST запросах
        if (\strtoupper($request->getMethod()) !== 'POST') {
            return $handler->handle($request);
        }

        $body = $request->getParsedBody();

        if (!isset($body['email'])) {
            return $handler->handle($request);
        }

        if (!EmailVerifier::verify($body['email'], EmailVerifierMode::WITH_MX_CHECKING)) {
            return new Response(\htmlspecialchars($body['email']) . ' не является корректным email адресом', 400);
        }

        return $handler->handle($request);
    }
}