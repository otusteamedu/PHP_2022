<?php

namespace Mselyatin\Patterns\application\interfaces\services;

use Mselyatin\Patterns\domain\collections\valueObjects\CompositionBakeryCollection;
use Mselyatin\Patterns\domain\constants\ReadinessStatusConstants;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

interface FastFoodServiceInterface
{
    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return BakeryInterface
     */
    public function createFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection
    ): BakeryInterface;
}