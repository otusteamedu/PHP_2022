<?php

declare(strict_types=1);

namespace App\App\Middleware;

use App\Infrastructure\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Миддлвара, которая проверяет корректность заполнения поля string в POST запросе
 * Требования:
 *  - поле есть и оно непустое
 *  - все открывающие скобки должны иметь закрывающие, при этом НЕ проверяется, что ряд открывающих/закрывающих скобок
 *      должен быть так обернут в скобки. Т.е
 *          (), ()(), (()())       - корректные варианты
 *          (, ), ((), ()), ())(   - некорректные
 */
class ValidateStringFieldMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // поле нас интересует только в POST запросах
        if (\strtoupper($request->getMethod()) !== 'POST') {
            return $handler->handle($request);
        }

        $body = $request->getParsedBody();

        if (!isset($body['string']) || $body['string'] === '') {
            return new Response('Поле \'string\' должно быть заполнено', 400);
        }

        if (!$this->validateBracesString($body['string'])) {
            return new Response('Поле \'string\' заполнено некорректно', 400);
        }

        return $handler->handle($request);
    }

    private function validateBracesString(string $string): bool
    {
        $braces = \str_split($string);
        $openBraceCount = 0;
        foreach ($braces as $brace) {
            if (!\in_array($brace, ['(', ')'])) {
                return false;
            }

            if ($brace === '(') {
                $openBraceCount++;
            } else {
                $openBraceCount--;
            }

            if ($openBraceCount < 0) {
                return false;
            }
        }

        if ($openBraceCount !== 0) {
            return false;
        }
        return true;
    }
}