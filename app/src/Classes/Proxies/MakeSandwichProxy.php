<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Proxies;

use Exception;
use SGakhramanov\Patterns\Classes\Products\Sandwich;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;

class MakeSandwichProxy implements ProductInterface
{
    private const REQUIRED_INGREDIENTS = ['булочки', 'салат', 'бекон'];
    private Sandwich $sandwich;

    public function __construct(Sandwich $sandwich)
    {
        $this->sandwich = $sandwich;
    }

    public function check(): Sandwich
    {
        try {
            return $this->make();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function make(): Sandwich
    {
        if (!$this->isAllRequiredIngredientsIn()) {
            unset($this->sandwich);
            throw new Exception('Сэндвич не содержит всех обязательных ингредиентов. Сэндвич не создан.');
        }

        return $this->sandwich;
    }

    private function isAllRequiredIngredientsIn(): bool
    {
        $requiredProducts = [];

        foreach (self::REQUIRED_INGREDIENTS as $reqIngredient) {
            if (!in_array($reqIngredient, $this->sandwich->ingredients)) {
                $requiredProducts[] = $reqIngredient;
            }
        }

        return empty($requiredProducts);
    }
}
