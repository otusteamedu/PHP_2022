<?php

declare(strict_types=1);

namespace app\Domain\Model\Ingredient;

abstract class AbstractIngredient {
    protected string $name;

    public function getName(): string {
        return $this->name;
    }
}
