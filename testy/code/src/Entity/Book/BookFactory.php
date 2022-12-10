<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Entity\Book;


use Mapaxa\ElasticSearch\Entity\Stock\Stock;

class BookFactory
{
    public static function create(string $sku, string $title, float $score, string $category, int $price, array $stock): Book
    {
        $stocks = [];
        foreach ($stock as $singleStock) {
            $stocks[] = new Stock($singleStock['shop'], $singleStock['stock']);
        }
        return new Book($sku, $title, $score, $category, $price, $stocks);
    }
}