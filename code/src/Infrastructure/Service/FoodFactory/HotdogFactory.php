<?php


namespace Study\Cinema\Infrastructure\Service\FoodFactory;

use Study\Cinema\Domain\Entity\Hotdog;
use Study\Cinema\Domain\Interface\FoodFactoryInterface;
use Study\Cinema\Infrastructure\Food;


class HotdogFactory extends FoodFactoryInterface
{
    public function make() : Food
    {
        // TODO: Implement make() method.
        return new Hotdog();
    }
}