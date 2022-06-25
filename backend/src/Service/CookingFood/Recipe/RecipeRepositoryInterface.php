<?php

namespace App\Service\CookingFood\Recipe;

use App\Service\CookingFood\Exception\RecipeNotFoundException;

interface RecipeRepositoryInterface
{
    /**
     * @throws RecipeNotFoundException
     */
    public function getById(int $id): Recipe;
}