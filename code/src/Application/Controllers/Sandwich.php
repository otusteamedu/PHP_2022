<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Domain\SandwichInterface;

class Sandwich extends Product implements SandwichInterface
{
    public function getName(): string
    {
        return "Sandwich";
    }

    public function getPrice(): float
    {
        return 70.0;
    }
}