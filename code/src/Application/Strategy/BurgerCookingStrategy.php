<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Strategy;

use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\CookableInterface;

class BurgerCookingStrategy implements CookableInterface
{
    public function __construct(private Burger $dish) {}

    public function cook(): void
    {
        fwrite(STDOUT, 'Стратегия: Приготовление бургера' . PHP_EOL);
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->fryCutlet();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->cutBun();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->addIngredients();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL . PHP_EOL);
    }

/*
    public function getDish(): Burger
    {
        return $this->dish;
    }
*/
}