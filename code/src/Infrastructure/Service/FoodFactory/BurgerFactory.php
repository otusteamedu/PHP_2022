<?php


namespace Study\Cinema\Infrastructure\Service\FoodFactory;

use Study\Cinema\Domain\Interface\FoodFactoryInterface;
use Study\Cinema\Domain\Entity\Burger;
use Study\Cinema\Infrastructure\Food;


class BurgerFactory implements FoodFactoryInterface
{
    public function make() : Food
    {
        // TODO: Implement make() method.
        return new Burger();
    }
}