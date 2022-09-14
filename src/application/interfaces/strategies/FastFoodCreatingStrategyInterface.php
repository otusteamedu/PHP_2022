<?php

namespace Mselyatin\Patterns\application\interfaces\strategies;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

interface FastFoodCreatingStrategyInterface
{
    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return mixed
     */
    public function createFastFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection
    ): mixed;
}