<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\State\StateInterface;

class DoneState implements StateInterface
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
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    public function getStringState(): string
    {
        return $this->dish->getDescription() . ' готов';
    }

    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}