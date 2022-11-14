<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

interface CookableInterface
{
    public function cook(): void;
    public function getDish(): AbstractDish;
}