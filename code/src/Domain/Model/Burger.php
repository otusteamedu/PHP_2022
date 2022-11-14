<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

use Nikolai\Php\Application\Observer\Observerable;
use Nikolai\Php\Application\Proxy\CookProxy;
use Nikolai\Php\Application\State\NewState;
use Nikolai\Php\Application\Strategy\BurgerCookingStrategy;
use Nikolai\Php\Domain\Observer\DishStateObserver;
use Nikolai\Php\Domain\Observer\DishStateSubject;
use Nikolai\Php\Domain\State\StateInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Burger extends AbstractDish
{
    private StateInterface $state;
    private DishStateSubject $dishStateSubject;
    private CookableInterface $cookingStrategy;

    public function __construct(private EventDispatcherInterface $eventDispatcher, protected string $description = 'Составной бургер', protected int $price = 350)
    {
        $this->dishStateSubject = new Observerable($this);
        $this->state = new NewState($this);
        $this->cookingStrategy = new CookProxy(new BurgerCookingStrategy($this), $this->eventDispatcher);
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

    public function cook(): void
    {
        $this->cookingStrategy->cook();
    }

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

    public function setState(StateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }

    public function getStringState(): string
    {
        return $this->state->getStringState();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
