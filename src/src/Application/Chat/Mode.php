<?php

declare(strict_types=1);

namespace App\Application\Chat;

enum Mode
{
    case SERVER;
    case CLIENT;

    public function getOtherSide(): self
    {
        return $this === self::SERVER ? self::CLIENT : self::SERVER;
    }
}
