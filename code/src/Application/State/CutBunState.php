<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\State;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Model\Burger;
use Cookapp\Php\Domain\Model\HotDog;
use Cookapp\Php\Domain\State\StateInterface;

/**
 * CutBun
 */
class CutBunState implements StateInterface
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
        fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
            . '. Состояние: ' . __CLASS__ . PHP_EOL);
    }

    /**
     * @return void
     */
    public function addIngredients(): void
    {
        if ($this->dish instanceof Burger || $this->dish instanceof HotDog) {
            $this->dish->setState(new AddIngredientsState($this->dish));
        } else {
            fwrite(STDOUT, 'Недопустимый переход состояний, метод ' . __METHOD__
                . '. Состояние: ' . __CLASS__ . PHP_EOL);
        }
    }

    /**
     * @return string
     */
    public function getStringState(): string
    {
        return 'Режим булочку в ' . $this->dish->getDescription();
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
