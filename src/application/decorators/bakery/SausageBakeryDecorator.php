<?php

namespace Mselyatin\Patterns\application\decorators\bakery;

use Mselyatin\Patterns\application\decorators\bakery\BakeryDecoratorAbstract;
use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;
use Mselyatin\Patterns\domain\valueObjects\bakery\BakeryTypeValue;
use Mselyatin\Patterns\domain\valueObjects\bakery\SausageValueObject;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;

class SausageBakeryDecorator extends BakeryDecoratorAbstract
{
    public function getType(): BakeryTypeValue
    {
        return $this->bakery->getType();
    }

    protected function getBakeryCompositionItem(): CompositionBakeryItemInterface
    {
        return SausageValueObject::make();
    }

    public function setStatus(ReadinessStatusValue $readinessStatusValue): void
    {
        $this->bakery->setStatus($readinessStatusValue);
    }

    public function getStatus(): ReadinessStatusValue
    {
        return $this->bakery->getStatus();
    }
}