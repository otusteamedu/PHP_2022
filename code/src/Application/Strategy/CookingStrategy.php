<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Strategy;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\CookableInterface;

class CookingStrategy implements CookableInterface
{
    public function __construct(private AbstractDish $dish) {}

    public function cook(): void
    {
        fwrite(STDOUT, 'Стратегия: приготовление блюда по-умолчанию' . PHP_EOL);
    }
}