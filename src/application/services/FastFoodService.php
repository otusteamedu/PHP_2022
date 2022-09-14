<?php

namespace Mselyatin\Patterns\application\services;

use Mselyatin\Patterns\application\interfaces\strategies\FastFoodCreatingStrategyInterface;
use Mselyatin\Patterns\domain\constants\ReadinessStatusConstants;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\application\interfaces\services\FastFoodServiceInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;
use Mselyatin\Patterns\domain\collections\valueObjects\CompositionBakeryCollection;

class FastFoodService implements FastFoodServiceInterface
{
    /** @var FastFoodCreatingStrategyInterface  */
    private FastFoodCreatingStrategyInterface $fastFoodCreatingStrategy;

    /**
     * @param FastFoodCreatingStrategyInterface $fastFoodCreatingStrategy
     */
    public function __construct(FastFoodCreatingStrategyInterface $fastFoodCreatingStrategy)
    {
        $this->fastFoodCreatingStrategy = $fastFoodCreatingStrategy;
    }

    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return BakeryInterface
     */
    public function createFood(
        ReadinessStatusValue $readinessStatusValue = new ReadinessStatusValue(ReadinessStatusConstants::WAIT),
        CollectionInterface $compositionBakeryCollection = new CompositionBakeryCollection()
    ): BakeryInterface {
        return $this->fastFoodCreatingStrategy->createFastFood(
            $readinessStatusValue,
            $compositionBakeryCollection
        );
    }
}