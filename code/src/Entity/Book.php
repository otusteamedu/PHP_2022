<?php

declare(strict_types=1);

namespace Otus\App\Entity;

class Book
{
    private string $sku;
    private string $title;
    private string $category;
    private int $price;

    private array $stocks;

    public function __construct(string $sku, string $title, string $category, int $price)
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
    }

    public function addStock(Stock $stock): void
    {
        $this->stocks[] = $stock;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStocks(): array
    {
        return $this->stocks;
    }
}

