<?php

namespace Mselyatin\Patterns\application\factories\bakery;

use Mselyatin\Patterns\domain\constants\BakeryTypesConstants;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\factories\FastFoodFactoryInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\models\Bakery;
use Mselyatin\Patterns\domain\valueObjects\bakery\BakeryTypeValue;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

class HotDogFastFoodFactory implements FastFoodFactoryInterface
{
    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return BakeryInterface
     */
    public function createFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection
    ): BakeryInterface
    {
        return Bakery::make(
            BakeryTypeValue::make(BakeryTypesConstants::BAKERY_HOT_DOG_TYPE),
            $readinessStatusValue,
            $compositionBakeryCollection
        );
    }
}