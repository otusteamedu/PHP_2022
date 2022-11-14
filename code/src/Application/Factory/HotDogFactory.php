<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Factory\AbstractDishFactory;
use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\HotDog;
use Psr\EventDispatcher\EventDispatcherInterface;

class HotDogFactory extends AbstractDishFactory
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(?string $description): AbstractDish
    {
        return $description ? new HotDog($this->eventDispatcher, $description) : new HotDog($this->eventDispatcher);
    }
}