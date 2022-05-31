<?php

namespace App\Application\AbstractFactory\Contract;

/**
 * ProductInterface
 */
interface ProductInterface
{
    /**
     * @param ProductInterface $ingredient
     * @return $this
     */
    public function add(ProductInterface $ingredient): static;
}