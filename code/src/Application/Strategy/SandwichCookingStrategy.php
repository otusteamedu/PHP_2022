<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Strategy;

use Nikolai\Php\Domain\Model\CookableInterface;
use Nikolai\Php\Domain\Model\Sandwich;

class SandwichCookingStrategy implements CookableInterface
{
    public function __construct(private Sandwich $dish) {}

    public function cook(): void
    {
        fwrite(STDOUT, 'Стратегия: приготовление сэндвича' . PHP_EOL);
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->addIngredients();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL . PHP_EOL);
    }

    public function getDish(): Sandwich
    {
        return $this->dish;
    }
}