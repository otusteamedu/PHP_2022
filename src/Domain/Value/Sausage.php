<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Value;

class Sausage extends AbstractIngredient
{
    public function name(): string
    {
        return 'Колбаса';
    }
}