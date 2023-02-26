<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http\DTO;

class Request implements RequestInterface
{
    public function __construct(
        private array $data,
        private string $method,
        private string $uri
    ) {
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function get(string $name): string
    {
        return $this->data[$name];
    }

    public function has(string $name): bool
    {
        return isset($this->data[$name]);
    }
}