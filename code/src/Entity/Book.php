<?php

declare(strict_types=1);

namespace Otus\App\Entity;

use Otus\App\Core\BookDTO;

class Book
{
    private string $sku;
    private string $title;
    private string $category;
    private int $price;

    private array $stocks;

    public function __construct(BookDTO $book_dto)
    {
        $this->sku = $book_dto->sku;
        $this->title = $book_dto->title;
        $this->category = $book_dto->category;
        $this->price = $book_dto->price;
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

