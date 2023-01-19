<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Factory;

/**
 * Factory dish factory interface
 */
interface FactoryDishFactoryInterface
{
    /**
     * @param string $nameDish
     * @return AbstractDishFactory
     */
    public function createDishFactory(string $nameDish): AbstractDishFactory;
}
