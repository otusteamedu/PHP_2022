<?php

namespace App\Application\Controllers;

use App\Domain\Contracts\HotDogInterface;

class HotDog extends Product implements HotDogInterface, \SplSubject
{
    protected bool $withMustard = false;

    public function addMustard()
    {
        $this->withMustard = true;
    }

    public function getName(): string
    {
        return "HotDog".($this->withMustard ? " с горчицей" : "");
    }

    public function getPrice(): float
    {
        return 100.0;
    }
}