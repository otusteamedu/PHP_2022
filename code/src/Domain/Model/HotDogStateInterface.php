<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

interface HotDogStateInterface
{
    public function boilSausage(): void;
    public function cutBun(): void;
    public function addIngredients(): void;
    public function addSauces(): void;
    public function toString(): string;
}