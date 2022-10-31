<?php
declare(strict_types=1);

namespace Domain\ValueObjects;

class Book
{
    protected string $name;
    protected string $category;
    protected string $sku;
    protected float $price;
    protected array $stocks;

    /**
     * @param string $name
     * @param string $category
     * @param string $sku
     * @param float $price
     * @param array $stocks
     */
    public function __construct(string $name, string $category, string $sku, float $price, array $stocks)
    {
        $this->name = $name;
        $this->category = $category;
        $this->sku = $sku;
        $this->price = $price;
        $this->stocks = $stocks;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return float
     */
    public function getPrice(): float
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