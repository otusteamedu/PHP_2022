<?php

namespace Mselyatin\Patterns\application\decorators\bakery;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;

abstract class BakeryDecoratorAbstract implements BakeryInterface
{
    /** @var BakeryInterface  */
    protected BakeryInterface $bakery;

    public function __construct(BakeryInterface $bakery)
    {
        $this->bakery = $bakery;
    }

    public function getComposition(): CollectionInterface
    {
        $bakeryCompositionItem = $this->getBakeryCompositionItem();
        $currentComposition = $this->bakery->getComposition();
        if (!$currentComposition->hasItem($bakeryCompositionItem)) {
            $currentComposition->add($bakeryCompositionItem);
        }

        return $currentComposition;
    }

    abstract protected function getBakeryCompositionItem(): CompositionBakeryItemInterface;
}