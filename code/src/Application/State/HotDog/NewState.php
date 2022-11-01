<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\State\HotDog;

use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\HotDogStateInterface;

class NewState implements HotDogStateInterface
{
    public function __construct(private HotDog $hotDog) {}

    public function boilSausage(): void
    {
        $this->hotDog->setState(new BoilSausageState($this->hotDog));
    }

    public function cutBun(): void
    {
        fwrite(STDOUT, 'Еще не сварена сосиска (boilSausage())! ');
    }

    public function addIngredients(): void
    {
        fwrite(STDOUT, 'Еще не сварена сосиска (boilSausage())! ');
    }

    public function addSauces(): void
    {
        fwrite(STDOUT, 'Еще не сварена сосиска (boilSausage())! ');
    }

    public function toString(): string
    {
        return 'Новый хотдог';
    }
}