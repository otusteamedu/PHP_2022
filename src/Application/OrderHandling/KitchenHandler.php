<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

use App\Application\UseCase\OrderStatusManagerInterface;
use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class KitchenHandler extends BaseHandler
{
    public function __construct(private readonly OrderStatusManagerInterface $orderStatusManager)
    {
    }

    public function handle(Order $order): void
    {
        $this->orderStatusManager->changeStatus($order, OrderStatus::COOKING);
        print_r('Заказ принят на кухне' . PHP_EOL);
        if (\random_int(1, 10) < 2) {
            print_r('Не хватает ингредиентов' . PHP_EOL);
            $this->orderStatusManager->changeStatus($order, OrderStatus::SOMETHING_WENT_WRONG);
            throw new \RuntimeException('Не удалось завершить заказ');
        }
        print_r('Заказ готовится' . PHP_EOL);
        print_r('Заказ готов к выдаче' . PHP_EOL);
        $this->orderStatusManager->changeStatus($order, OrderStatus::WAITING_FOR_WAITER);
        $this->nextHandler->handle($order);
    }
}