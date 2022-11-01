<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

interface BurgerStateInterface
{
    public function fryCutlet(): void;
    public function cutBun(): void;
    public function addIngredients(): void;
    public function toString(): string;
}