<?php

namespace App\Application\OrderHandling;

use App\Domain\Entity\Order;

interface OrderHandlerInterface
{
    public function setNext(OrderHandlerInterface $handler): void;

    public function handle(Order $order): void;
}