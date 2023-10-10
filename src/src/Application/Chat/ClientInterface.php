<?php

declare(strict_types=1);

namespace App\Application\Chat;

interface ClientInterface
{
    public function checkOtherSide(): void;
}
