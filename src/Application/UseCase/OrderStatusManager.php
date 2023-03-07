<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class OrderStatusManager
{
    public function changeStatus(Order $order, OrderStatus $status): void
    {
        $order->changeStatus($status);
    }
}