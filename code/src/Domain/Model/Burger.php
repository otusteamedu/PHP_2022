<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Model;

use Cookapp\Php\Application\Observer\Observerable;
use Cookapp\Php\Application\Proxy\CookProxy;
use Cookapp\Php\Application\State\NewState;
use Cookapp\Php\Application\Strategy\BurgerCookingStrategy;
use Cookapp\Php\Domain\Observer\DishStateObserver;
use Cookapp\Php\Domain\Observer\DishStateSubject;
use Cookapp\Php\Domain\State\StateInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Bugrer dish
 */
class Burger extends AbstractDish
{
    private StateInterface $state;
    private DishStateSubject $dishStateSubject;
    private CookableInterface $cookingStrategy;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param string|null $description
     * @param int|null $price
     */
    public function __construct(private EventDispatcherInterface $eventDispatcher, ?string $description = null, ?int $price = null)
    {
        $this->description = ($description ?: 'Бургер');
        $this->price = ($price ?: 350);
        $this->dishStateSubject = new Observerable($this);
        $this->state = new NewState($this);
        $this->cookingStrategy = new CookProxy(new BurgerCookingStrategy($this), $this->eventDispatcher);
    }

    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function attach(DishStateObserver $observer): void
    {
        $this->dishStateSubject->attach($observer);
    }

    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function detach(DishStateObserver $observer): void
    {
        $this->dishStateSubject->detach($observer);
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        $this->dishStateSubject->notify();
    }

    /**
     * @return void
     */
    public function cook(): void
    {
        $this->cookingStrategy->cook();
    }

    /**
     * @return void
     */
    public function fryCutlet(): void
    {
        $this->state->fryCutlet();
    }

    /**
     * @return void
     */
    public function boilSausage(): void
    {
        $this->state->boilSausage();
    }

    /**
     * @return void
     */
    public function addSauces(): void
    {
        $this->state->addSauces();
    }

    /**
     * @return void
     */
    public function cutBun(): void
    {
        $this->state->cutBun();
    }

    /**
     * @return void
     */
    public function addIngredients(): void
    {
        $this->state->addIngredients();
    }

    /**
     * @return void
     */
    public function done(): void
    {
        $this->state->done();
    }

    /**
     * @param StateInterface $state
     * @return void
     */
    public function setState(StateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }

    /**
     * @return string
     */
    public function getStringState(): string
    {
        return $this->state->getStringState();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}
