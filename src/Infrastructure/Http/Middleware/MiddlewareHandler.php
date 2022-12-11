<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareHandler implements RequestHandlerInterface
{
    private ?MiddlewareInterface $middleware = null;

    private ?RequestHandlerInterface $handler = null;

    public function __construct(
        MiddlewareInterface $middleware,
        RequestHandlerInterface $handler
    ) {
        $this->middleware = $middleware;
        $this->handler    = $handler;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}