<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Domain\Model\Controllers\Burger;
use Otus\App\Domain\Model\Interface\BurgerInterface;

class BurgerFactory implements ProductFactoryInterface
{
    public function create() : BurgerInterface
    {
        return new Burger();
    }
}