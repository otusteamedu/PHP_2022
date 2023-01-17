<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\State;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\HotDog;
use Cookapp\Php\Domain\State\StateInterface;

class BoilSausageState implements StateInterface
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
        if ($this->dish instanceof HotDog) {
            $this->dish->setState(new AddSaucesState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
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
        return 'Варим сосиску в ' . $this->dish->getDescription();
    }

    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}