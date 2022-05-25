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
    public static function createCoffee();

    /**
     * @return mixed
     */
    public static function createTea();
}