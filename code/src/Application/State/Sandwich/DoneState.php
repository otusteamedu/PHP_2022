<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\Sandwich;

use Nikolai\Php\Domain\Model\Sandwich;
use Nikolai\Php\Domain\Model\SandwichStateInterface;

class DoneState implements SandwichStateInterface
{
    public function __construct() {}

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Сэндвич уже готов! ');
    }

    public function toString(): string
    {
        return 'Сэндвич готов';
    }
}