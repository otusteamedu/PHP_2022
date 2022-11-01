<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Burger;

use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\BurgerStateInterface;

class CutBunState implements BurgerStateInterface
{
    public function __construct(private Burger $burger) {}

    public function fryCutlet(): void
    {
        fwrite(STDOUT, 'Котлета уже пожарена (cutBun())! ');
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Булочка уже разрезана (addIngredients())! ');
    }

    public function addIngredients(): void
    {
        $this->burger->setState(new DoneState());
    }

    public function toString(): string
    {
        return 'Режим булочку';
    }
}