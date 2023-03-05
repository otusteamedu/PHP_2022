<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class KitchenHandler extends BaseHandler
{
    public function handle(Order $order): void
    {
        $order->changeStatus(OrderStatus::COOKING);
        print_r('Заказ принят на кухне' . PHP_EOL);
        if (\random_int(1, 10) < 2) {
            print_r('Не хватает ингредиентов' . PHP_EOL);
            $order->changeStatus(OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Заказ готовится' . PHP_EOL);
        print_r('Заказ готов к выдаче' . PHP_EOL);
        $order->changeStatus(OrderStatus::WAITING_FOR_WAITER);
        $this->nextHandler->handle($order);
    }
}