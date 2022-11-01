<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\HotDog;

use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\HotDogStateInterface;

class DoneState implements HotDogStateInterface
{
    public function __construct(private HotDog $hotDog) {}

    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Хотдог уже готов! ');
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Хотдог уже готов! ');
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Хотдог уже готов! ');
    }

    public function addSauces(): void
    {
        fwrite(STDOUT, 'Хотдог уже готов! ');
    }

    public function toString(): string
    {
        return 'Хотдог готов';
    }
}