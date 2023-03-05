<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http\DTO;

class Response implements ResponseInterface
{
    private string $body = '';

    private int $code = 200;

    public function withBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}