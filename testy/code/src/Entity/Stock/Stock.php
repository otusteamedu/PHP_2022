<?php
declare(strict_types=1);


namespace Mapaxa\ElasticSearch\Entity\Stock;

class Stock
{
    /** @var string */
    private $shop;
    /** @var int */
    private $stock;

    public function __construct(string $shop, int $stock)
    {
        $this->shop = $shop;
        $this->stock = $stock;
    }

    public function getShop(): string
    {
        return $this->shop;
    }

    public function getStock(): int
    {
        return $this->stock;
    }


}