<?php

namespace App\Application\Controllers;

use App\Domain\Contracts\BurgerInterface;

class Burger extends Product implements BurgerInterface, \SplSubject
{
    public function getName(): string
    {
        return "Burger";
    }

    public function getPrice(): float
    {
        return 150.0;
    }

}