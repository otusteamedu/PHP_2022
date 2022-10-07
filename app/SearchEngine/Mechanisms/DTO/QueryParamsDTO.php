<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\DTO;

final class QueryParamsDTO
{
    public string $title;
    public string $titles;
    public string $category;
    public string $categories;
    public string $price;
    public string $price_range;
    public string $stock;
    public string $stock_range;
    public string $shop;
    public string $shops;

    public function __construct(
        string $title = '',
        string $titles = '',
        string $category = '',
        string $categories = '',
        string $price = '',
        string $price_range = '',
        string $stock = '',
        string $stock_range = '',
        string $shop = '',
        string $shops = '',
    ) {
        $this->title = $title;
        $this->titles = $titles;
        $this->category = $category;
        $this->categories = $categories;
        $this->price = $price;
        $this->price_range = $price_range;
        $this->stock = $stock;
        $this->stock_range = $stock_range;
        $this->shop = $shop;
        $this->shops = $shops;
    }
}
