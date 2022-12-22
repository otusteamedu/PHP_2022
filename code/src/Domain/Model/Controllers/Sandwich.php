<?php

namespace Otus\App\Domain\Model\Controllers;

use Otus\App\Domain\Model\Interface\SandwichInterface;

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