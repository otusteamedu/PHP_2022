<?php

namespace app\Application\Dto;

class CreateOrderRequestDTO {
    /**
     * @var CreateOrderRequestItemDTO[]
     */
    private array $items;

    public function __construct(array $items) {
        $this->checkRequest($items);
        $this->addItems($items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return CreateOrderRequestDTO
     */
    public function addItems(array $items): CreateOrderRequestDTO
    {
        foreach ($items as $item) {
            $this->items[] = new CreateOrderRequestItemDTO($item);
        }

        return $this;
    }

    private function checkRequest(array $items) {
        foreach ($items as $item) {
            if (0 !== count(array_diff(['productName', 'quantity', 'extraIngredients'], array_keys($item)))) {
                throw new \Exception('Неверный запрос');
            }
        }
    }
}
