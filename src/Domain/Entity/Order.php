<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Order
{
    /**
     * Номер заказа. Используется также в качестве PK
     */
    private string $orderNumber;

    /**
     * Оплачен ли заказ
     */
    private bool $isPaid;

    public function __construct(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
        $this->isPaid = false;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function isPaid(): bool
    {
        return $this->isPaid;
    }

    public function pay(): void
    {
        $this->isPaid = true;
    }
}