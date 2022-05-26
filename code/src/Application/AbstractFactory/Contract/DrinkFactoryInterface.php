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
    public function createCoffee(): mixed;

    /**
     * @return mixed
     */
    public function createTea(): mixed;
}