<?php

declare(strict_types=1);

namespace Svatel\Code\Http\Response;

final class Response
{
    private int $statusCode;
    private string $message;
    private ?array $body = null;

    public function __construct(int $statusCode, string $message, ?array $body = null)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->body = $body;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
