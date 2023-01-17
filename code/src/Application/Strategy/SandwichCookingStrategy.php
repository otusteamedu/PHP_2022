<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Strategy;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\CookableInterface;

class SandwichCookingStrategy implements CookableInterface
{
    public function __construct(private AbstractDish $dish) {}

    public function cook(): void
    {
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->addIngredients();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);

        $this->dish->done();
        fwrite(STDOUT, 'Состояние: ' . $this->dish->getStringState() . PHP_EOL);
    }

    public function getDish(): AbstractDish
    {
        return $this->dish;
    }
}