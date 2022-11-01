<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

use Nikolai\Php\Application\State\Sandwich\NewState;

class Sandwich extends AbstractDish
{
    private SandwichStateInterface $state;

    public function __construct()
    {
        $this->state = new NewState($this);
    }

    public function addIngredients(): void
    {
        $this->state->addIngredients();
    }

    public function setState(SandwichStateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }

    public function getStringState(): string
    {
        return $this->state->toString();
    }
}