<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Value;

class Bread extends AbstractIngredient
{
    public function name(): string
    {
        return 'Булка';
    }
}