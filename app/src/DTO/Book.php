<?php

namespace HW10\App\DTO;

class Book
{
    private string $sku;

    private string $title;

    private string $category;

    private int $price;

    /** @var Store[] */
    private array $stores;

    /**
     * @param string $sku
     * @param string $title
     * @param string $category
     * @param int $price
     */
    public function __construct(string $sku, string $title, string $category, int $price)
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
    }

    public function addStores(Store $store): void
    {
        $this->stores[] = $store;
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

    public function getStores(): array
    {
        return $this->stores;
    }
}