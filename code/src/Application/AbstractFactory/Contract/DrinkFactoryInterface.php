<?php

namespace App\Application\AbstractFactory\Contract;

/**
 * DrinkFactoryInterface
 */
interface DrinkFactoryInterface extends ProductFactoryInterface
{
    /**
     * @return ProductInterface
     */
    public function createCoffee(): ProductInterface;

    /**
     * @return ProductInterface
     */
    public function createTea(): ProductInterface;
}