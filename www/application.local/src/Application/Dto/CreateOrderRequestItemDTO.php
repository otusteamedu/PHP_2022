<?php

namespace app\Application\Dto;

class CreateOrderRequestItemDTO {
    public int $quantity;
    public string $productName;
    public array $extraIngredients = [];

    public function __construct(array $item) {
        $this->quantity = $item['quantity'];
        $this->productName = $item['productName'];
        $this->extraIngredients = $item['extraIngredients'];
    }
}
