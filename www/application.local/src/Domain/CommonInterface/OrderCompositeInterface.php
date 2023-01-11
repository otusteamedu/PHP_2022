<?php

namespace app\Domain\CommonInterface;

interface OrderCompositeInterface {
    public function getPrice(): int;
    public function hasChildItems(): bool;
    public function addItem(OrderCompositeInterface $item): void;
}
