<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Model;

abstract class AbstractDish
{
    /**
     * Допустимые состояния блюд:
     *  - Бургер: New -> FryCutlet -> CutBun -> AddIngredients -> Done
     *  - Хотдог: New -> BoilSausage -> AddSauces -> CutBun -> AddIngredients -> Done
     *  - Сэндвич: New -> AddIngredients -> Done
     */

    protected string $description;
    protected int $price;

    abstract public function getDescription(): string;
    abstract public function getPrice(): int;
    abstract function cook(): void;
}