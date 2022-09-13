<?php

declare(strict_types=1);

namespace App\Application\Factories;

use App\Application\Controllers\HotDog;
use App\Domain\Contracts\HotDogInterface;


class HotDogFactory implements ProductFactoryInterface
{
    public function create() : HotDogInterface {
        return new HotDog();
    }
}