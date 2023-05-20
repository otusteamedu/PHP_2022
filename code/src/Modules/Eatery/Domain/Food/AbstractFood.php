<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Food;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\FoodRecipe;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddCutlet;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddSauce;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddBuns;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddTomato;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddLettuce;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddOnion;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddSausage;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddCucumber;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddKetchup;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddMayonnaise;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddMustard;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddCheese;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddBread;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddHam;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\AddChicken;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Recipe;
use DI\Container;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;

abstract class AbstractFood implements FoodFactory
{
    protected Recipe $recipe;

    public function __construct(Container $container)
    {
        $this->recipe = $container->get(FoodRecipe::class);
    }

    public function addIngredients(?Ingredients $ingredients)
    {
        $this->recipe->addIngredients($ingredients);
    }

    /**
     * @return array
     */
    abstract public function createRecipe(): array;

    /**
     * @param $configRecipe
     * @return array
     */
    protected function prepareRecipe($configRecipe): array
    {
        array_walk($configRecipe, function ($ingredient) {
            $ingredientName = ucfirst($ingredient);
            $className = "Nikcrazy37\Hw14\Modules\Eatery\Domain\Recipe\Ingredient\Add$ingredientName";

            $this->recipe = new $className($this->recipe);
        });

        return $this->recipe->cook();
    }
}