<?php

namespace Nikcrazy37\Hw14\Modules\Eatery\Application\Order;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Order\Order;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\FoodFactory;
use SplObserver;

interface OrderInterface
{
    /**
     * @param FoodFactory $food
     * @param SplObserver $observer
     */
    public function __construct(FoodFactory $food, SplObserver $observer);

    /**
     * @param OrderInterface $stream
     * @return OrderInterface
     */
    public function setNext(OrderInterface $stream): self;

    /**
     * @param string $food
     * @return Order|null
     */
    public function create(string $food): ?Order;
}