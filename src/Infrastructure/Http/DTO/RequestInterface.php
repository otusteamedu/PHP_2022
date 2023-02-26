<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http\DTO;

interface RequestInterface
{
    public function get(string $name): string;

    public function has(string $name): bool;

    public function method(): string;

    public function uri(): string;
}