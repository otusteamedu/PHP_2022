<?php

namespace App\Application\Strategy\Contract;

/**
 *  StrategyFastFoodInterface
 */
interface StrategyFastFoodInterface extends StrategyInterface
{
    /**
     * @return mixed
     */
    public function makeBurger(): mixed;

    /**
     * @return mixed
     */
    public function makeHotDog(): mixed;

    /**
     * @return mixed
     */
    public function makeSandwich(): mixed;
}