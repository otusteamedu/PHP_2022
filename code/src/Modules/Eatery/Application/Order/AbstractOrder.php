<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Application\Order;

use DI\Container;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Order\Order;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\FoodFactory;
use SplObserver;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Notifier;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\QualityFood;

abstract class AbstractOrder implements OrderInterface, \SplSubject
{
    public Order $order;
    protected FoodFactory $food;
    protected SplObserver $observer;
    private OrderInterface $next;
    private \SplObjectStorage $observers;

    public function __construct(Container $container)
    {

        $this->observers = new \SplObjectStorage();
//        $this->food = $container->get(FoodFactory::class);
        $this->food = $container->get(QualityFood::class);
        $this->observer = $container->get(Notifier::class);
//        $this->food = $food;
//        $this->observer = $observer;
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

    public function addIngredients(?Ingredients $ingredients)
    {
        $this->food->addIngredients($ingredients);
        return $this;
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