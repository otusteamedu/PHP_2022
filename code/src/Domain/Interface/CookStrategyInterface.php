<?php


namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Infrastructure\Food;


interface CookStrategyInterface
{
    public function __construct(FoodBuilder $builder);
    public function cook(array $data): Food;

}