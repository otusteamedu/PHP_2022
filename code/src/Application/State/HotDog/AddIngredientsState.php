<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\HotDog;

use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\HotDogStateInterface;

class AddIngredientsState implements HotDogStateInterface
{
    public function __construct(private HotDog $hotDog) {}

    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Сосиска уже сварена (addSauces())! ');
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Булочка уже разрезана (addSauces())! ');
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Инградиенты уже добавлены (addSauces())! ');
    }

    public function addSauces(): void
    {
        $this->hotDog->setState(new DoneState($this->hotDog));
    }

    public function toString(): string
    {
        return 'Добавляем инградиенты';
    }
}