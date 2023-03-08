<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Proxies;

use Exception;
use SGakhramanov\Patterns\Classes\Products\Burger;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;

class MakeBurgerProxy implements ProductInterface
{
    private const REQUIRED_INGREDIENTS = ['булочки', 'салат', 'котлета'];
    private Burger $burger;

    public function __construct(Burger $burger)
    {
        $this->burger = $burger;
    }

    public function check(): Burger
    {
        try {
            return $this->make();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function make(): Burger
    {
        if (!$this->isAllRequiredIngredientsIn()) {
            unset($this->burger);
            throw new Exception('Бургер не содержит всех обязательных ингредиентов. Бургер не создан.');
        }

        return $this->burger;
    }

    private function isAllRequiredIngredientsIn(): bool
    {
        $requiredProducts = [];

        foreach (self::REQUIRED_INGREDIENTS as $reqIngredient) {
            if (!in_array($reqIngredient, $this->burger->ingredients)) {
                $requiredProducts[] = $reqIngredient;
            }
        }

        return empty($requiredProducts);
    }
}
