<?php

namespace App\Application\UseCase;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

interface OrderStatusManagerInterface
{
    public function changeStatus(Order $order, OrderStatus $status): void;
}