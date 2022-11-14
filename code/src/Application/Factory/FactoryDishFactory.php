<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Factory\AbstractDishFactory;
use Nikolai\Php\Domain\Factory\FactoryDishFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class FactoryDishFactory implements FactoryDishFactoryInterface
{
    private const POSTFIX_FACTORY_CLASS = 'Factory';

    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDishFactory(string $nameDish): AbstractDishFactory
    {
        $classDishFactory = __NAMESPACE__ . "\\" . $nameDish . self::POSTFIX_FACTORY_CLASS;
        if (!class_exists($classDishFactory)) {
            throw new \Exception('Не найдена фабрика для блюда: ' . $nameDish);
        }

        return new $classDishFactory($this->eventDispatcher);
    }
}