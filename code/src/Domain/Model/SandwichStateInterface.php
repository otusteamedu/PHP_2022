<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

interface SandwichStateInterface
{
    public function addIngredients(): void;
    public function toString(): string;
}