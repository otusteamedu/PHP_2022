<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Order;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\Food;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Status\Status;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Status\StatusEnum;

class Order
{
    private OrderId $id;
    private Food $food;
    private Status $status;

    public function __construct(Food $food)
    {
        $this->id = new OrderId();
        $this->food = $food;
        $this->status = new Status(StatusEnum::PENDING);
    }

    /**
     * @return OrderId
     */
    public function getId(): OrderId
    {
        return $this->id;
    }

    /**
     * @return Food
     */
    public function getFood(): Food
    {
        return $this->food;
    }

    /**
     * @param Food $food
     * @return Order
     */
    public function setFood(Food $food): self
    {
        $this->food = $food;
        return $this;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     * @return Order
     */
    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }
}