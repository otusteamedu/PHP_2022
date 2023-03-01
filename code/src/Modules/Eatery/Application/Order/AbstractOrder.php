<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Application\Order;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Order\Order;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\FoodFactory;
use SplObserver;

abstract class AbstractOrder implements OrderInterface, \SplSubject
{
    public Order $order;
    protected FoodFactory $food;
    protected SplObserver $observer;
    private OrderInterface $next;
    private \SplObjectStorage $observers;

    public function __construct(FoodFactory $food, SplObserver $observer)
    {
        $this->observers = new \SplObjectStorage();
        $this->food = $food;
        $this->observer = $observer;
    }

    /**
     * @param OrderInterface $stream
     * @return OrderInterface
     */
    public function setNext(OrderInterface $stream): OrderInterface
    {
        $this->next = $stream;

        return $stream;
    }

    /**
     * @param string $food
     * @return Order|null
     */
    public function create(string $food): ?Order
    {
        if (!$this->next) {
            return null;
        }

        return $this->next->create($food);
    }

    /**
     * @param SplObserver $observer
     * @return void
     */
    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    /**
     * @param SplObserver $observer
     * @return void
     */
    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}