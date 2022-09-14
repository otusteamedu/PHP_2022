<?php

namespace Mselyatin\Patterns\application\strategies\creating;

use Mselyatin\Patterns\application\interfaces\strategies\FastFoodCreatingStrategyInterface;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\factories\FastFoodFactoryInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

abstract class FastFoodCreatingStrategyAbstract implements FastFoodCreatingStrategyInterface
{
    /** @var FastFoodFactoryInterface  */
    protected FastFoodFactoryInterface $fastFoodFactory;

    /**
     * @param FastFoodFactoryInterface $fastFoodFactory
     */
    public function __construct(FastFoodFactoryInterface $fastFoodFactory)
    {
        $this->fastFoodFactory = $fastFoodFactory;
    }

    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @param CollectionInterface $compositionBakeryCollection
     * @return mixed
     */
    public function createFastFood(
        ReadinessStatusValue $readinessStatusValue,
        CollectionInterface $compositionBakeryCollection
    ): BakeryInterface {
        return $this->fastFoodFactory->createFood($readinessStatusValue, $compositionBakeryCollection);
    }
}