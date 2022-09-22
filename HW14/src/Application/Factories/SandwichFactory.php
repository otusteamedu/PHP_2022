<?php

declare(strict_types=1);

namespace App\Application\Factories;

use App\Application\Controllers\Sandwich;
use App\Domain\Contracts\SandwichInterface;


class SandwichFactory implements ProductFactoryInterface
{
    public function create() : SandwichInterface {
        return new Sandwich();
    }
}