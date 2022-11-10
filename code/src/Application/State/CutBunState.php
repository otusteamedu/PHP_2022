<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\State\StateInterface;

class CutBunState implements StateInterface
{
    public function __construct(private AbstractDish $dish) {}

    public function fryCutlet(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function addSauces(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function addIngredients(): void
    {
        if ($this->dish instanceof Burger || $this->dish instanceof HotDog) {
            $this->dish->setState(new AddIngredientsState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function getStringState(): string
    {
        return 'Режим булочку в ' . $this->dish->getDescription();
    }

    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}