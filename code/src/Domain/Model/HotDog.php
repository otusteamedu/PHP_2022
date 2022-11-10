<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

class HotDog extends AbstractDish
{
/*
    private HotDogStateInterface $state;

    public function __construct()
    {
        parent::__construct();
        $this->state = new NewState($this);
    }

    public function boilSausage(): void
    {
        $this->state->boilSausage();
    }

    public function cutBun(): void
    {
        $this->state->cutBun();
    }

    public function addIngredients(): void
    {
        $this->state->addIngredients();
    }

    public function addSauces(): void
    {
        $this->state->addSauces();
    }

    public function setState(HotDogStateInterface $state): void
    {
        $this->state = $state;
        $this->notify();
    }

    public function getStringState(): string
    {
        return $this->state->toString();
    }
*/
    public function getDescription(): string
    {
        return 'Хот-дог';
    }

    public function getPrice(): int
    {
        return 222;
    }
}