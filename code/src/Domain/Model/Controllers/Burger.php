<?php

namespace Otus\App\Domain\Model\Controllers;

use Otus\App\Domain\Model\Interface\BurgerInterface;

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