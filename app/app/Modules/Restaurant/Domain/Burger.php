<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Domain;

use Exception;

abstract class Burger
{
    abstract public function getTitle(): string;

    abstract public function getComposition(): string;
}
