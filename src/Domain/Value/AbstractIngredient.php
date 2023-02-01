<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Value;

use DKozlov\Otus\Domain\Value\Interface\IngredientInterface;

abstract class AbstractIngredient implements IngredientInterface
{
    protected ?self $nextIngredient = null;

    public function setNextIngredient(self $nextIngredient): self
    {
        $this->nextIngredient = $nextIngredient;

        return $nextIngredient;
    }

    public function getNextIngredient(): ?self
    {
        return $this->nextIngredient;
    }
}