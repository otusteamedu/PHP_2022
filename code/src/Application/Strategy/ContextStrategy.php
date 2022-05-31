<?php

declare(strict_types=1);

namespace App\Application\Strategy;

use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Application\Strategy\Contract\StrategyInterface;

/**
 * ContextStrategy
 */
class ContextStrategy implements StrategyInterface
{
    /**
     * @var array
     */
    private array $listOrder = [];

    /**
     * @param ProductInterface $orderItem
     * @return void
     */
    public function addToOrder(ProductInterface $orderItem) : void
    {
        $this->listOrder[] = $orderItem;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        foreach($this->listOrder as $order) {
           dump($order);
        }
    }
}