<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Model;

use Cookapp\Php\Application\Observer\Observerable;
use Cookapp\Php\Application\Proxy\CookProxy;
use Cookapp\Php\Application\State\NewState;
use Cookapp\Php\Application\Strategy\SandwichCookingStrategy;
use Cookapp\Php\Domain\Observer\DishStateObserver;
use Cookapp\Php\Domain\Observer\DishStateSubject;
use Cookapp\Php\Domain\State\StateInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Sandwich extends AbstractDish
{
    private StateInterface $state;
    private DishStateSubject $dishStateSubject;
    private CookableInterface $cookingStrategy;

    public function __construct(private EventDispatcherInterface $eventDispatcher, protected string $description = 'Составной сэндвич', protected int $price = 250)
    {
        $this->dishStateSubject = new Observerable($this);
        $this->state = new NewState($this);
        $this->cookingStrategy = new CookProxy(new SandwichCookingStrategy($this), $this->eventDispatcher);
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