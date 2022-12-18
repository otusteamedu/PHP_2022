<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Domain\BurgerInterface;

class Burger extends Product implements BurgerInterface
{
    public function getName(): string
    {
        return "Burger";
    }

    public function getPrice(): float
    {
        return 100.0;
    }

}