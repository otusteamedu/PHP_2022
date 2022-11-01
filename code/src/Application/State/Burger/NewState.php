<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Burger;

use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\BurgerStateInterface;

class NewState implements BurgerStateInterface
{
    public function __construct(private Burger $burger) {}

    public function fryCutlet(): void
    {
        $this->burger->setState(new FryCutletState($this->burger));
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Еще не пожарена котлета (fryCutlet())! ');
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Еще не пожарена котлета (fryCutlet())! ');
    }

    public function toString(): string
    {
        return 'Новый бургер';
    }
}