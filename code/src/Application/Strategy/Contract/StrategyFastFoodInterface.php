<?php

namespace App\Application\Strategy\Contract;

use App\Application\AbstractFactory\Contract\ProductInterface;

/**
 *  StrategyFastFoodInterface
 */
interface StrategyFastFoodInterface extends StrategyInterface
{
    /**
     * @return ProductInterface
     */
    public function makeBurger(): ProductInterface;

    /**
     * @return ProductInterface
     */
    public function makeHotDog(): ProductInterface;

    /**
     * @return ProductInterface
     */
    public function makeSandwich(): ProductInterface;
}