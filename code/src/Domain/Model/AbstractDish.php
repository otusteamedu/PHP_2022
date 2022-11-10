<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

use JetBrains\PhpStorm\Pure;
use Nikolai\Php\Application\Observer\Observerable;
use Nikolai\Php\Application\State\NewState;
use Nikolai\Php\Domain\Observer\DishStateObserver;
use Nikolai\Php\Domain\Observer\DishStateSubject;
use Nikolai\Php\Domain\State\StateInterface;

abstract class AbstractDish implements StateInterface
{
    protected DishStateSubject $dishStateSubject;

    protected string $description = '';
    protected int $price = 0;

    /**
     * Допустимые состояния блюд:
     *  - Бургер: New -> FryCutlet -> CutBun -> AddIngredients -> Done
     *  - Хотдог: New -> BoilSausage -> AddSauces -> CutBun -> AddIngredients -> Done
     *  - Сэндвич: New -> AddIngredients -> Done
     */
    protected StateInterface $state;

    #[Pure]
    public function __construct()
    {
        $this->dishStateSubject = new Observerable($this);
        $this->state = new NewState($this);
    }

    public function attach(DishStateObserver $observer): void
    {
        $this->dishStateSubject->attach($observer);
    }

    public function detach(DishStateObserver $observer): void
    {
        $this->dishStateSubject->detach($observer);
    }

    public function notify(): void
    {
        $this->dishStateSubject->notify();
    }

    abstract public function getDescription(): string;
    abstract public function getPrice(): int;

    public function fryCutlet(): void
    {
        $this->state->fryCutlet();
    }

    public function boilSausage(): void
    {
        $this->state->boilSausage();
    }

    public function addSauces(): void
    {
        $this->state->addSauces();
    }

    public function cutBun(): void
    {
        $this->state->cutBun();
    }

    public function addIngredients(): void
    {
        $this->state->addIngredients();
    }

    public function done(): void
    {
        $this->state->done();
    }

    public function getStringState(): string
    {
        return $this->state->getStringState();
    }

    public function setState(StateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }
}