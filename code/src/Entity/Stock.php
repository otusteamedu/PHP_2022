<?php

declare(strict_types=1);

namespace Otus\App\Entity;

class Stock
{
    private string $name;

    private int $stock;

    public function __construct(string $name, int $stock)
    {
        $this->name = $name;
        $this->stock = $stock;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStock(): int
    {
        return $this->stock;
    }
}

