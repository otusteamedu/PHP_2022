<?php

declare(strict_types=1);

namespace Otus\App\Core;

/**
 * Books data structure (DTO)
 */
class BookDTO
{
    public string $sku;
    public string $title;
    public string $category;
    public int $price;

    private array $stocks;

    /**
     * @param string $sku
     * @param string $title
     * @param string $category
     * @param int $price
     */
    public function __construct(string $sku = '', string $title = '', string $category = '', int $price = 0)
    {
        $this->sku = $sku;
        $this->title = $title;
        $this->category = $category;
        $this->price = $price;
    }
}
