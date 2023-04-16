<?php

namespace Otus\Task14\Factory\Products;

use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Decorator\Ingredients\SaladIngredient;
use Otus\Task14\Factory\AbstractProduct;


class HotDogProduct extends AbstractProduct
{
    public function getName(): string
    {
        return 'Хот-дог';
    }

    public function getDefaultIngredient(): IngredientInterface
    {
        return new SaladIngredient();
    }

}