<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\ElasticSearch;

class QueryDTO
{
    public string $stock;
    public string $title;
    public string $category;
    public int $price;

    /**
     * @param string $stock
     * @param string $title
     * @param string $category
     * @param int $price
     */
    public function __construct(string $stock = '', string $title = '', string $category = '', int $price = 0)
    {
        $this->stock = $stock;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
    }
}