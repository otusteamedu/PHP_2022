<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\HotDog;

use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\HotDogStateInterface;

class CutBunState implements HotDogStateInterface
{
    public function __construct(private HotDog $hotDog) {}

    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Сосиска уже сварена (addIngredients())! ');
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Булочка уже разрезана (addIngredients())! ');
    }

    public function addIngredients(): void
    {
        $this->hotDog->setState(new AddIngredientsState($this->hotDog));
    }

    public function addSauces(): void
    {
        fwrite(STDOUT, 'Еще не добавлены инградиенты (addIngredients())! ');
    }

    public function toString(): string
    {
        return 'Режим булочку';
    }
}