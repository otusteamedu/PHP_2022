<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Application\AbstractFactory\ProductFactoryInterface;
use Otus\App\Domain\SandwichInterface;
use Otus\App\Application\Controllers\Sandwich;

class SandwichFactory implements ProductFactoryInterface
{
    public function create() : SandwichInterface
    {
        return new Sandwich();
    }
}