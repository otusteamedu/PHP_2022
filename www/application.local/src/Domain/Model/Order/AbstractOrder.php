<?php

namespace app\Domain\Model\Order;

use app\Domain\CommonInterface\OrderCompositeInterface;
use app\Domain\ValueObject\OrderItem;

abstract class AbstractOrder implements OrderCompositeInterface {
    /**
     * @var OrderItem[]
     */
    protected array $items = [];

    public function addItem(OrderCompositeInterface $item): void {
        $this->items[] = $item;
    }

    public function getPrice(): int {
        if (count($this->items) === 0) return 0;
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->getPrice();
        }
        return $price;
    }

    public function hasChildItems(): bool {
        return true;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
