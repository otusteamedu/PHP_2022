<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Sandwich;

use Nikolai\Php\Domain\Model\Sandwich;
use Nikolai\Php\Domain\Model\SandwichStateInterface;

class NewState implements SandwichStateInterface
{
    public function __construct(private Sandwich $sandwich) {}

    public function addIngredients(): void
    {
        $this->sandwich->setState(new DoneState());
    }

    public function toString(): string
    {
        return 'Новый сэндвич';
    }
}