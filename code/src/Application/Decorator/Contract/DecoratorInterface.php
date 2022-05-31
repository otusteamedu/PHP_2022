<?php

namespace App\Application\Decorator\Contract;

use App\Application\AbstractFactory\Contract\ProductInterface;

/**
 * DecoratorInterface
 */
interface DecoratorInterface
{
    /**
     * @return mixed
     */
    public function add(): ProductInterface;
}