<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\Product\ProductInterface;
use App\Domain\Enum\OrderStatus;

class Order
{
    private OrderStatus $status;
    /**
     * @param array<ProductInterface> $products
     */
    public function __construct(private array $products)
    {
        $this->status = OrderStatus::NEW;
    }

    public function getAllProducts(): array
    {
        return $this->products;
    }

    public function addProduct(ProductInterface $product): void
    {
        $this->products[] = $product;
    }

    public function changeStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}