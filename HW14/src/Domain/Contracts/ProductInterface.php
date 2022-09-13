<?php

declare(strict_types=1);

namespace App\Domain\Contracts;

interface ProductInterface
{
    public CONST TYPE_HOTDOG = 1;
    public CONST TYPE_BURGER = 2;
    public CONST TYPE_SANDWICH = 3;

    public function getName() : string;
    public function getPrice() : float;
}