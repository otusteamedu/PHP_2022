<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Application\AbstractFactory\ProductFactoryInterface;
use Otus\App\Domain\HotDogInterface;
use Otus\App\Application\Controllers\HotDog;

class HotDogFactory implements ProductFactoryInterface
{
    public function create() : HotDogInterface
    {
        return new HotDog();
    }
}