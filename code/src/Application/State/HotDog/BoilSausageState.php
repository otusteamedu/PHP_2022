<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\HotDog;

use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\HotDogStateInterface;

class BoilSausageState implements HotDogStateInterface
{
    public function __construct(private HotDog $hotDog) {}

    public function boilSausage(): void
    {
        fwrite(STDOUT, 'Сосиска уже сварена (cutBun())! ');
    }

    public function cutBun(): void
    {
        $this->hotDog->setState(new CutBunState($this->hotDog));
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Еще не разрезана булочка (cutBun())! ');
    }

    public function addSauces(): void
    {
        fwrite(STDOUT, 'Еще не разрезана булочка (cutBun())! ');
    }

    public function toString(): string
    {
        return 'Варим сосиску';
    }
}