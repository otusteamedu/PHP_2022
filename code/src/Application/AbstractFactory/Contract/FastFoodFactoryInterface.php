<?php

namespace App\Application\AbstractFactory\Contract;

/**
 * FastFoodFactoryInterface
 */
interface FastFoodFactoryInterface extends ProductFactoryInterface
{
    /**
     * @return ProductInterface
     */
    public function createBurger(): ProductInterface;

    /**
     * @return ProductInterface
     */
    public function createHotDog(): ProductInterface;

    /**
     * @return ProductInterface
     */
    public function createSandwich(): ProductInterface;
}