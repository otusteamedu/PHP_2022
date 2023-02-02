<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Factory;

use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Bread;
use DKozlov\Otus\Domain\Value\Cutlet;
use DKozlov\Otus\Domain\Value\Salad;
use DKozlov\Otus\Domain\Value\Sauce;
use DKozlov\Otus\Domain\Value\Sausage;
use DKozlov\Otus\Domain\Value\Tomato;

class IngredientFactory implements IngredientFactoryInterface
{
    public function buildSalad(): AbstractIngredient
    {
        return new Salad();
    }

    public function buildBread(): AbstractIngredient
    {
        return new Bread();
    }

    public function buildCutlet(): AbstractIngredient
    {
        return new Cutlet();
    }

    public function buildSauce(): AbstractIngredient
    {
        return new Sauce();
    }

    public function buildSausage(): AbstractIngredient
    {
        return new Sausage();
    }

    public function buildTomato(): AbstractIngredient
    {
        return new Tomato();
    }

}