<?php


namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Infrastructure\Food;


interface FoodFactoryInterface
{
    const TYPE_BURGER  = 1;
    const TYPE_HOTDOG  = 2;
    public function make() : Food;

}