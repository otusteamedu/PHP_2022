<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Factory;

interface FactoryDishFactoryInterface
{
    public function createDishFactory(string $nameDish): AbstractDishFactory;
}
