<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Factory\Interface;

use DKozlov\Otus\Domain\Value\AbstractIngredient;
interface IngredientFactoryInterface
{
    public function buildSalad(): AbstractIngredient;

    public function buildBread(): AbstractIngredient;

    public function buildCutlet(): AbstractIngredient;

    public function buildSauce(): AbstractIngredient;

    public function buildSausage(): AbstractIngredient;

    public function buildTomato(): AbstractIngredient;
}