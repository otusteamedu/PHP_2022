<?php

namespace App\Application\AbstractFactory\Contract;

/**
 * DrinkFactoryInterface
 */
interface DrinkFactoryInterface extends ProductFactoryInterface
{
    /**
     * @return mixed
     */
    public function createCoffee(): static;

    /**
     * @return mixed
     */
    public function createTea(): static;
}