<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Application\AbstractFactory\ProductFactoryInterface;
use Otus\App\Domain\BurgerInterface;
use Otus\App\Application\Controllers\Burger;


class BurgerFactory implements ProductFactoryInterface
{
    public function create() : BurgerInterface
    {
        return new Burger();
    }
}