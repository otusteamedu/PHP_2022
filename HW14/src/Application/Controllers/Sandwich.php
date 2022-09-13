<?php

namespace App\Application\Controllers;

use App\Domain\Contracts\SandwichInterface;

class Sandwich extends Product implements SandwichInterface, \SplSubject
{
    protected bool $isVeryHot = false;

    /**
     * @param bool $isVeryHot
     */
    public function __construct(bool $isVeryHot = false)
    {
        parent::__construct();
        $this->isVeryHot = $isVeryHot;
    }

    public function getName(): string
    {
        return "Sandwich".($this->isVeryHot ? " горячий" : "");
    }

    public function getPrice(): float
    {
        return 120.0;
    }

    public function heat()
    {
        $this->isVeryHot = true;
    }
}