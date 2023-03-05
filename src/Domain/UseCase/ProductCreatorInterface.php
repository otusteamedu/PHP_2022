<?php

namespace App\Domain\UseCase;

use App\Domain\Entity\Product\ProductInterface;

interface ProductCreatorInterface
{
    public function create(): ProductInterface;
}