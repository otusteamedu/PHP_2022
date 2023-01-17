<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\State;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\State\StateInterface;

class AddIngredientsState implements StateInterface
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
        return 'Добавляем инградиенты в ' . $this->dish->getDescription();
    }

    public function done(): void
    {
        $this->dish->setState(new DoneState($this->dish));
    }
}