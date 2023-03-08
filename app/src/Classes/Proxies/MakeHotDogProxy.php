<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Proxies;

use Exception;
use SGakhramanov\Patterns\Classes\Products\HotDog;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;

class MakeHotDogProxy implements ProductInterface
{
    private const REQUIRED_INGREDIENTS = ['булочки', 'салат', 'сосиска'];
    private HotDog $hotDog;
    public function __construct(HotDog $hotDog)
    {
        $this->hotDog = $hotDog;
    }

    public function check(): HotDog
    {
        try {
            return $this->make();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function make(): HotDog
    {
        if (!$this->isAllRequiredIngredientsIn()) {
            unset($this->hotDog);
            throw new Exception('Хот-Дог не содержит всех обязательных ингредиентов. Хот-Дог не создан.');
        }

        return $this->hotDog;
    }

    private function isAllRequiredIngredientsIn(): bool
    {
        $requiredProducts = [];

        foreach (self::REQUIRED_INGREDIENTS as $reqIngredient) {
            if (!in_array($reqIngredient, $this->hotDog->ingredients)) {
                $requiredProducts[] = $reqIngredient;
            }
        }

        return empty($requiredProducts);
    }
}
