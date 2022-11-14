<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Factory\AbstractDishFactory;
use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\Sandwich;
use Psr\EventDispatcher\EventDispatcherInterface;

class SandwichFactory extends AbstractDishFactory
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(?string $description): AbstractDish
    {
        return $description ? new Sandwich($this->eventDispatcher, $description) : new Sandwich($this->eventDispatcher);
    }
}