<?php

declare(strict_types=1);

namespace app\Infrastructure\Http\Controller;

use app\Application\Dto\CreateOrderRequestDTO;
use app\Application\Service\OrderService;

class RestaurantController
{
    public function run(): string {
        $orderData = $this->getUserOrderData();
        $service = new OrderService();
        $order = $service->createOrder($orderData);
        return $service->cookOrder($order);
    }

    private function getUserOrderData(): CreateOrderRequestDTO {
        return new CreateOrderRequestDTO(
        [
            [
                'productName' => 'Burger',
                'quantity' => 20,
                'extraIngredients' => [
                    'Salad',
                    'Onion'
                ]
            ],
            [
                'productName' => 'Hotdog',
                'quantity' => 2,
                'extraIngredients' => [
                    'Salad',
                    'Pepper'
                ]
            ],
            [
                'productName' => 'Sandwich',
                'quantity' => 1,
                'extraIngredients' => []
            ]
        ]);
    }
}
