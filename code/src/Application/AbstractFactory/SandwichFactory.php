<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Domain\Model\Controllers\Sandwich;
use Otus\App\Domain\Model\Interface\SandwichInterface;

class SandwichFactory implements ProductFactoryInterface
{
    public function create() : SandwichInterface
    {
        return new Sandwich();
    }
}