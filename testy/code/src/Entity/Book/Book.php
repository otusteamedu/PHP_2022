<?php
declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Entity\Book;


class Book
{
    /** @var string */
    private $sku;
    /** @var string */
    private $title;
    /** @var float */
    private $score;
    /** @var string */
    private $category;
    /** @var int */
    private $price;
    /** @var array */
    private $stocks;

    public function __construct(string $sku, string $title, float $score, string $category, int $price, array $stocks)
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->score = $score;
        $this->category = $category;
        $this->price = $price;
        $this->stocks = $stocks;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getScore(): float
    {
        return $this->score;
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

    public function getPrettyfiedStocks(): string
    {
        $rows = '';
        foreach ($this->getStocks() as $stock) {
            $rows .= $stock->getShop() . ' => ' . $stock->getStock() . "шт; ";
        }
        return $rows;
    }

    public static function getPropertiesNames(): array
    {
        $properties = get_class_vars(self::class);
        return array_map(function ($propertyName) {
            return ucfirst($propertyName);
        }, array_keys($properties));
    }
}