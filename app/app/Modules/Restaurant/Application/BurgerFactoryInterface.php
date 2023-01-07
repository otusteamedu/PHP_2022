<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application;

use App\Modules\Restaurant\Domain\Burger;

interface BurgerFactoryInterface
{
    public function create(): Burger;
}
