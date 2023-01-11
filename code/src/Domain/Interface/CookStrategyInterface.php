<?php


namespace Study\Cinema\Domain\Interface;

use Study\Cinema\Infrastructure\Food;
use Study\Cinema\Infrastructure\Service\EventManager\EventManager;


interface CookStrategyInterface
{
    public function __construct(FoodBuilder $builder, EventManager $eventManager);
    public function cook(array $data): Food;

}