<?php

declare(strict_types=1);

namespace App\Chat;

enum ServerMode
{
    case SERVER;
    case CLIENT;

    public function getOtherSide(): self
    {
        return $this === self::SERVER ? self::CLIENT : self::SERVER;
    }
}
