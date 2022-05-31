<?php

namespace App\Application\Strategy\Contract;

use App\Application\AbstractFactory\Contract\ProductInterface;

/**
 * StrategyDrinkInterface
 */
interface StrategyDrinkInterface extends StrategyInterface
{
    /**
     * @return ProductInterface
     */
    public function makeCoffee(): ProductInterface;

    /**
     * @return mixed
     */
    public function makeTea(): ProductInterface;
}