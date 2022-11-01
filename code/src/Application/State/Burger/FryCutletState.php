<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Burger;

use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\BurgerStateInterface;

class FryCutletState implements BurgerStateInterface
{
    public function __construct(private Burger $burger) {}

    public function fryCutlet(): void
    {
        fwrite(STDOUT, 'Котлета уже пожарена (cutBun())! ');
    }

    public function cutBun(): void
    {
        $this->burger->setState(new CutBunState($this->burger));
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Еще не разрезана булочка (cutBun())! ');
    }

    public function toString(): string
    {
        return 'Жарим котлету';
    }
}
