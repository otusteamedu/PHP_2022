<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Strategy;

use Nikolai\Php\Domain\Model\CookableInterface;
use Nikolai\Php\Domain\Model\HotDog;

class HotDogCookingStrategy implements CookableInterface
{
    public function __construct(private HotDog $dish) {}

    public function cook(): void
    {
        fwrite(STDOUT, 'Стратегия: Приготовление хотдога' . PHP_EOL);
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->boilSausage();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->cutBun();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->addIngredients();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->addSauces();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL . PHP_EOL);
    }

    public function getDish(): HotDog
    {
        return $this->dish;
    }
}