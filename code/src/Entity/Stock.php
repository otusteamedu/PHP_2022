<?php

declare(strict_types=1);

namespace Otus\App\Entity;

/**
 * Books stock
 */
class Stock
{
    private string $name;

    private int $stock;

    /**
     * @param string $name
     * @param int $stock
     */
    public function __construct(string $name, int $stock)
    {
        $this->name = $name;
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }
}
