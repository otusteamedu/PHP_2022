<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Burger;

use Nikolai\Php\Domain\Model\BurgerStateInterface;

class DoneState implements BurgerStateInterface
{
    public function fryCutlet(): void
    {
        fwrite(STDOUT, 'Бургер уже готов! ');
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Бургер уже готов! ');
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Бургер уже готов! ');
    }

    public function toString(): string
    {
        return 'Бургер готов';
    }
}