<?php


namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Infrastructure\Food;

abstract class FoodFactoryInterface
{
    const TYPE_BURGER  = 1;
    const TYPE_HOTDOG  = 2;
    abstract function make() : Food;

}