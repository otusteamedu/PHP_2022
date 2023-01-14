<?php

declare(strict_types=1);

namespace Sveta\Code\Http;

final class Request
{
    private array $data;

    public function __construct(array $data)
    {
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
