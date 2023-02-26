<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http\DTO;

class Response implements ResponseInterface
{
    private string $body = '';

    public function withBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}