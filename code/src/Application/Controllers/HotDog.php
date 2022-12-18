<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Domain\HotDogInterface;

class HotDog extends Product implements HotDogInterface
{

    public function getName(): string
    {
        return "HotDog";
    }

    public function getPrice(): float
    {
        return 270.0;
    }
}