<?php

namespace App\Domain\Contracts;

interface SandwichInterface extends ProductInterface
{
    public function heat();
}