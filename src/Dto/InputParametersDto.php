<?php

namespace Dto;

class InputParametersDto
{
    private ?string $title = '';
    private ?string $sku = '';
    private ?string $category = '';
    private ?int $priceLow = 0;
    private ?int $priceHigh = 0;
    private ?int $limit = 0;
    private ?int $offset = 0;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setPriceLow(int $priceLow): void
    {
        $this->priceLow = $priceLow;
    }

    public function getPriceLow(): int
    {
        return $this->priceLow;
    }

    public function setPriceHigh(int $priceHigh): void
    {
        $this->priceHigh = $priceHigh;
    }

    public function getPriceHigh(): int
    {
        return $this->priceHigh;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
