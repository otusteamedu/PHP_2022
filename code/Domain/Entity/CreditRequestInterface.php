<?php

declare(strict_types=1);

namespace App\Domain\Entity;

interface CreditRequestInterface
{
    public function send(): void;
}