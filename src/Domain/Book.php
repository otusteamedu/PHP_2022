<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Domain;

class Book
{
    public function __construct(
        private string $sku,
        private string $title,
        private float $cost,
        private bool $inStock
    ) {
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->inStock;
    }
}