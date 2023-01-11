<?php

namespace app\Domain\ValueObject;

use app\Domain\Model\Ingredient\AbstractIngredient;

class ProductComposition {
    private array $ingredients = [];

    public function __construct(array $ingredients) {
        foreach ($ingredients as $ingredient) {
            $this->addIngredient($ingredient);
        }
    }

    public function addIngredient(AbstractIngredient $ingredient): void {
        $this->ingredients[] = $ingredient;
    }

    /**
     * @return AbstractIngredient[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

}
