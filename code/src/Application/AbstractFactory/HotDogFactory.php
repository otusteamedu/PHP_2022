<?php

declare(strict_types=1);

namespace Otus\App\Application\AbstractFactory;

use Otus\App\Domain\Model\Controllers\HotDog;
use Otus\App\Domain\Model\Interface\HotDogInterface;

class HotDogFactory implements ProductFactoryInterface
{
    public function create() : HotDogInterface
    {
        return new HotDog();
    }
}