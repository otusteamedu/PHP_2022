<?php

declare(strict_types=1);

namespace Sveta\Code\Http;

final class Response
{
    private int $statusCode;
    private string $message;

    public function __construct(int $statusCode, string $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }
}