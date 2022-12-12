<?php

declare(strict_types=1);

namespace Otus\App\Entity;

use Otus\App\Core\BookDTO;

/**
 * Books
 */
class Book
{
    private string $sku;
    private string $title;
    private string $category;
    private int $price;

    private array $stocks;

    /**
     * Construct
     * @param BookDTO $book_dto
     */
    public function __construct(BookDTO $book_dto)
    {
        $this->sku = $book_dto->sku;
        $this->title = $book_dto->title;
        $this->category = $book_dto->category;
        $this->price = $book_dto->price;
    }

    /**
     * @param Stock $stock
     * @return void
     */
    public function addStock(Stock $stock): void
    {
        $this->stocks[] = $stock;
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
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function getStocks(): array
    {
        return $this->stocks;
    }
}
