<?php

namespace Mselyatin\Patterns\infrastructure\mappers;

use Mselyatin\Patterns\application\interfaces\strategies\FastFoodCreatingStrategyInterface;
use Mselyatin\Patterns\application\strategies\creating\BurgerFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\HotDogFastFoodCreatingStrategy;
use Mselyatin\Patterns\application\strategies\creating\SandwichFastFoodCreatingStrategy;
use Mselyatin\Patterns\domain\constants\BakeryTypesConstants;

class TypeProductToStrategyMapper
{
    protected const MAP = [
        BakeryTypesConstants::BAKERY_BURGER_TYPE => BurgerFastFoodCreatingStrategy::class,
        BakeryTypesConstants::BAKERY_SANDWICH_TYPE => SandwichFastFoodCreatingStrategy::class,
        BakeryTypesConstants::BAKERY_HOT_DOG_TYPE => HotDogFastFoodCreatingStrategy::class,
    ];

    /**
     * @param int $type
     * @return ?string
     */
    public static function map(int $type): ?string
    {
        return self::MAP[$type] ?? null;
    }
}