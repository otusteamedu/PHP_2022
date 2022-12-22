<?php

namespace Otus\App\Domain\Model\Controllers;

use Otus\App\Domain\Model\Interface\HotDogInterface;

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