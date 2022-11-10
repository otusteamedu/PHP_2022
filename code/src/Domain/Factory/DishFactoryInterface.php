<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Factory;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\CookableInterface;

interface DishFactoryInterface
{
    public function createDish(): AbstractDish;
    public function createCookProxy(AbstractDish $dish): CookableInterface;
}