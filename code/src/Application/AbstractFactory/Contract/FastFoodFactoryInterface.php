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
    public static function createBurger(): mixed;

    /**
     * @return mixed
     */
    public static function createHotDog(): mixed;

    /**
     * @return mixed
     */
    public static function createSandwich(): mixed;
}