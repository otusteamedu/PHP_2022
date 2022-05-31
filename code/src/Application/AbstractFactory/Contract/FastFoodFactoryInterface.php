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
    public function createBurger(): static;

    /**
     * @return mixed
     */
    public function createHotDog(): static;

    /**
     * @return mixed
     */
    public function createSandwich(): static;
}