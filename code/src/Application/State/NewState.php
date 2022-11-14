<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\Sandwich;
use Nikolai\Php\Domain\State\StateInterface;

class NewState implements StateInterface
{
    public function __construct(private AbstractDish $dish) {}

    public function fryCutlet(): void
    {
        if ($this->dish instanceof Burger) {
            $this->dish->setState(new FryCutletState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function boilSausage(): void
    {
        if ($this->dish instanceof HotDog) {
            $this->dish->setState(new BoilSausageState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function addSauces(): void
    {
        if ($this->dish instanceof HotDog) {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function cutBun(): void
    {
        if ($this->dish instanceof Burger || $this->dish instanceof HotDog) {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function addIngredients(): void
    {
        if ($this->dish instanceof Sandwich) {
            $this->dish->setState(new AddIngredientsState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    public function getStringState(): string
    {
        return 'Новый ' . $this->dish->getDescription();
    }

    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}