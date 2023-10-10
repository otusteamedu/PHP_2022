<?php

declare(strict_types=1);

namespace App\Domain;

class Message
{
    public function __construct(private readonly string $body)
    {
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
