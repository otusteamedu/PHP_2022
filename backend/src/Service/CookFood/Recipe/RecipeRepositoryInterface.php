<?php

namespace App\Service\CookFood\Recipe;

use App\Service\CookFood\Exception\RecipeNotFoundException;

interface RecipeRepositoryInterface
{
    /**
     * @throws RecipeNotFoundException
     */
    public function getById(int $id): Recipe;
}