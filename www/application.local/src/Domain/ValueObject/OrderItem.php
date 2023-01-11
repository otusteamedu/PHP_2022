<?php

namespace app\Domain\ValueObject;

use app\Domain\CommonInterface\OrderCompositeInterface;
use app\Domain\Model\Product\AbstractProduct;

class OrderItem implements OrderCompositeInterface {
    public int $quantity;
    public AbstractProduct $product;

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return OrderItem
     */
    public function setQuantity(int $quantity): OrderItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return AbstractProduct
     */
    public function getProduct(): AbstractProduct
    {
        return $this->product;
    }

    /**
     * @param AbstractProduct $product
     * @return OrderItem
     */
    public function setProduct(AbstractProduct $product): OrderItem
    {
        $this->product = $product;
        return $this;
    }

    public function hasChildItems(): bool {
        return false;
    }

    public function getPrice(): int {
        return $this->product->getPrice() * $this->quantity;
    }

    public function addItem(OrderCompositeInterface $item): void {}
}
