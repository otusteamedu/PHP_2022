<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

use Nikolai\Php\Application\State\Burger\NewState;

class Burger extends AbstractDish
{
    private BurgerStateInterface $state;

    public function __construct()
    {
        $this->state = new NewState($this);
    }

    public function fryCutlet(): void
    {
        $this->state->fryCutlet();
    }

    public function cutBun(): void
    {
        $this->state->cutBun();
    }

    public function addIngredients(): void
    {
        $this->state->addIngredients();
    }

    public function setState(BurgerStateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }

    public function getStringState(): string
    {
        return $this->state->toString();
    }
}
