<?php

namespace App\Application\Strategy\Contract;

use App\Application\AbstractFactory\Contract\ProductInterface;

/**
 *  StrategyFastFoodInterface
 */
interface StrategyFastFoodInterface extends StrategyInterface
{
    /**
     * @return mixed
     */
    public function makeBurger(): ProductInterface;

    /**
     * @return mixed
     */
    public function makeHotDog(): ProductInterface;

    /**
     * @return mixed
     */
    public function makeSandwich(): ProductInterface;
}