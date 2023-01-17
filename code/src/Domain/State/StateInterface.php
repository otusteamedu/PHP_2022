<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\State;

interface StateInterface
{
    public function fryCutlet(): void;
    public function boilSausage(): void;
    public function addSauces(): void;
    public function cutBun(): void;
    public function addIngredients(): void;
    public function done(): void;
    public function getStringState(): string;
}