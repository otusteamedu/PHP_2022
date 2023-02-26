<?php

namespace Otus\Task13\Core\Routing;

class Route
{
    public function __construct(private readonly string $method, private readonly string $path, private readonly mixed $handler)
    {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

}