<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure;

use http\Exception\InvalidArgumentException;

final class Request
{
    private array $data;

    public function __construct(array $data)
    {
        if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $data['email'])) {
            throw new InvalidArgumentException('Не валидна почта');
        }
        $this->data = $data;
    }

    public static function create(array $data): self
    {
        return new self($data);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
