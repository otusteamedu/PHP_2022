<?php
declare(strict_types=1);

namespace Application\ValueObjects;

class Filter
{
    protected ?string $name;
    protected ?string $category;
    protected ?float $maxPrice;
    protected ?float $minPrice;
    protected ?int $minStock;

    /**
     * @param string|null $name
     * @param float|null $maxPrice
     * @param float|null $minPrice
     * @param int|null $minStock
     */
    public function __construct(?string $name, ?string $category, ?float $maxPrice, ?float $minPrice, ?int $minStock)
    {
        $this->name = $name;
        $this->category = $category;
        $this->maxPrice = $maxPrice;
        $this->minPrice = $minPrice;
        $this->minStock = $minStock;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @return float|null
     */
    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    /**
     * @return float|null
     */
    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    /**
     * @return int|null
     */
    public function getMinStock(): ?int
    {
        return $this->minStock;
    }



}