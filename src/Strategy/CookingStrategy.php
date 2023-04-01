<?php

namespace Otus\Task14\Strategy;

use Otus\Task14\Strategy\Contract\CookingStrategyInterface;

class CookingStrategy
{
    private ?CookingStrategyInterface $cookingStrategy = null;

    public function __construct(CookingStrategyInterface $cookingStrategy)
    {

    }

    public function cooking(): void
    {
        $this->cookingStrategy->cooking();
    }
}