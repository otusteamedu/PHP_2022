<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Decorator;

use Nikolai\Php\Domain\Model\AbstractDish;

class Pepper extends DishDecorator
{
    public function __construct(private AbstractDish $dish)
    {
        parent::__construct();
    }

    public function getDescription(): string
    {
        return $this->dish->getDescription() . ' Перец';
    }

    public function getPrice(): int
    {
        return $this->dish->getPrice() + 21;
    }
}