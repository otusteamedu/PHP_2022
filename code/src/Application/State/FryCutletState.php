<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\State\StateInterface;

class FryCutletState implements StateInterface
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
        if ($this->dish instanceof Burger) {
            $this->dish->setState(new CutBunState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function getStringState(): string
    {
        return 'Жарим котлету в ' . $this->dish->getDescription();
    }

    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}