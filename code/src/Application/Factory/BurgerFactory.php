<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Factory;

use Cookapp\Php\Domain\Factory\AbstractDishFactory;
use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\Burger;
use Psr\EventDispatcher\EventDispatcherInterface;

class BurgerFactory extends AbstractDishFactory
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(?string $description): AbstractDish
    {
        return $description ? new Burger($this->eventDispatcher, $description) : new Burger($this->eventDispatcher);
    }
}