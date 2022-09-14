<?php

namespace Mselyatin\Patterns\domain\interfaces\factories;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

interface FastFoodFactoryInterface
{
    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return mixed
     */
    public function createFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection
    ): mixed;
}