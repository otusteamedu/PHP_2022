<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http\DTO;

interface ResponseInterface
{
    public function withBody(string $body): self;

    public function getBody(): string;

    public function withCode(int $code): self;

    public function getCode(): int;
}