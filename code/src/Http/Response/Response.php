<?php

declare(strict_types=1);

namespace src\Http\Response;

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