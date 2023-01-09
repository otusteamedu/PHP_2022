<?php


namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Infrastructure\Food;


interface CookStrategyInterface
{
    public function __construct(Food $food);
    public function cook(array $data): Food;

}