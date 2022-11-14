<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Factory;

interface FactoryDishFactoryInterface
{
    public function createDishFactory(string $nameDish): AbstractDishFactory;
}