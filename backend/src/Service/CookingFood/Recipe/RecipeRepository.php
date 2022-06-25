<?php

namespace App\Service\CookingFood\Recipe;

use App\Service\CookingFood\Exception\RecipeNotFoundException;
use App\Service\CookingFood\Ingredient\Ingredient;

class RecipeRepository implements RecipeRepositoryInterface
{
    /**
     * @throws RecipeNotFoundException
     */
    public function getById(int $id): Recipe
    {
        $recipes = [
            'fakeBurgerRecipe',
            'fakeHotDogRecipe',
            'fakeHamburgerRecipe',
        ];
        if (array_key_exists($id, $recipes)) {
            $recipeFn = $recipes[$id];
            return $this->$recipeFn();
        }
        throw new RecipeNotFoundException("Recipe with id $id not found", 404);
    }

    private function fakeBurgerRecipe(): RecipeInterface
    {
        $recipe = new Recipe();
        $recipe->addIngredientToList(new Ingredient('ingredient 1'));
        $recipe->addIngredientToList(new Ingredient('ingredient 2'));
        $recipe->addIngredientToList(new Ingredient('ingredient 3'));
        return $recipe;
    }

    private function fakeHotDogRecipe(): RecipeInterface
    {
        $recipe = new Recipe();
        $recipe->addIngredientToList(new Ingredient('ingredient 4'));
        $recipe->addIngredientToList(new Ingredient('ingredient 5'));
        $recipe->addIngredientToList(new Ingredient('ingredient 6'));
        return $recipe;
    }

    private function fakeHamburgerRecipe(): RecipeInterface
    {
        $recipe = new Recipe();
        $recipe->addIngredientToList(new Ingredient('ingredient 7'));
        $recipe->addIngredientToList(new Ingredient('ingredient 8'));
        $recipe->addIngredientToList(new Ingredient('ingredient 9'));
        return $recipe;
    }
}