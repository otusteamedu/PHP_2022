<?php

declare(strict_types=1);

namespace Svatel\Code\Infrastructure\Http;

use InvalidArgumentException;

final class Request
{
    private array $data;

    public function __construct(array $data)
    {
        if (!isset($data['title']) && !isset($data['body'])) {
            throw new InvalidArgumentException('Неверное тело запроса');
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
