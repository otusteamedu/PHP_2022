<?php

declare(strict_types=1);

namespace App\Application\Factories;

use App\Application\Controllers\Burger;
use App\Domain\Contracts\BurgerInterface;


class BurgerFactory implements ProductFactoryInterface
{
    public function create() : BurgerInterface {
        return new Burger();
    }
}