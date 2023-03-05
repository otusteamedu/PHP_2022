<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class OrderStatusObserver implements OrderStatusManagerInterface
{
    public function __construct(private readonly OrderStatusManager $orderStatusManager)
    {
    }

    public function changeStatus(Order $order, OrderStatus $status): void
    {
        $this->preChangeStatus($order, $status);
        $this->orderStatusManager->changeStatus($order, $status);
        $this->postChangeStatus($order, $status);
    }

    private function preChangeStatus(Order $order, OrderStatus $status): void
    {
        if (\random_int(1, 10) < 2) {
            throw new \RuntimeException('Недопустимый переход статуса');
        }
    }

    private function postChangeStatus(Order $order, OrderStatus $status)
    {
        if (\random_int(1, 10) < 2) {
            throw new \RuntimeException('Санитарная служба изъяла заказ');
        }
    }
}