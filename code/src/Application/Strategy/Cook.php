<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Strategy;

use Nikolai\Php\Domain\Model\CookableInterface;

class Cook implements CookableInterface
{
    public function __construct(private CookableInterface $cookingStrategy) {}

    public function setCookingStrategy(CookableInterface $cookingStrategy): void
    {
        $this->cookingStrategy = $cookingStrategy;
    }

    public function cook(): void
    {
        $this->cookingStrategy->cook();
    }
}