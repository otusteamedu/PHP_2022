<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Factory;

use Cookapp\Php\Domain\Factory\AbstractDishFactory;
use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\Burger;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Burger
 */
class BurgerFactory extends AbstractDishFactory
{
    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @param string|null $description
     * @return AbstractDish
     */
    public function createDish(?string $description): AbstractDish
    {
        return new Burger($this->eventDispatcher, $description);
    }
}
