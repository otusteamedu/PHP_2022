<?php

namespace App\Application\Strategy\Contract;

/**
 * StrategyDrinkInterface
 */
interface StrategyDrinkInterface extends StrategyInterface
{
    /**
     * @return mixed
     */
    public function makeCoffee(): mixed;

    /**
     * @return mixed
     */
    public function makeTea(): mixed;
}