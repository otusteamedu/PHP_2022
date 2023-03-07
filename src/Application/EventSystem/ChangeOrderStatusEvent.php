<?php

declare(strict_types=1);

namespace App\Application\EventSystem;

use App\Domain\Entity\Order;
use App\Domain\Enum\OrderStatus;

class ChangeOrderStatusEvent implements EventInterface
{
    private Order $order;
    private OrderStatus $newStatus;
    private string $comment;

    public function __construct(
        Order $order,
        OrderStatus $newStatus,
        string $comment = ''
    )
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
        $this->comment = $comment;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getNewStatus(): OrderStatus
    {
        return $this->newStatus;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}