<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\State;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\Burger;
use Cookapp\Php\Domain\State\StateInterface;

/**
 * Fry cutlet state
 */
class FryCutletState implements StateInterface
{
    /**
     * @param AbstractDish $dish
     */
    public function __construct(private AbstractDish $dish)
    {
    }

    /**
     * @return void
     */
    public function fryCutlet(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    /**
     * @return void
     */
    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    /**
     * @return void
     */
    public function addSauces(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    /**
     * @return void
     */
    public function cutBun(): void
    {
        if ($this->dish instanceof Burger) {
            $this->dish->setState(new CutBunState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый вызов метода ' . __METHOD__ . ' для ' . $this->dish->getDescription()
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    /**
     * @return void
     */
    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    /**
     * @return string
     */
    public function getStringState(): string
    {
        return 'Жарим котлету в ' . $this->dish->getDescription();
    }

    /**
     * @return void
     */
    public function done(): void
    {
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }
}
