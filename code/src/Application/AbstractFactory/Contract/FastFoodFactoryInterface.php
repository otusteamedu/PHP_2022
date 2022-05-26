<?php

namespace App\Application\AbstractFactory\Contract;

/**
 * FastFoodFactoryInterface
 */
interface FastFoodFactoryInterface extends ProductFactoryInterface
{
    /**
     * @return mixed
     */
    public function createBurger(): mixed;

    /**
     * @return mixed
     */
    public function createHotDog(): mixed;

    /**
     * @return mixed
     */
    public function createSandwich(): mixed;
}