<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Input;

class InputHandler
{
    /**
     * @return array|bool
     */
    public static function getParam(): array|bool
    {
        return getopt("", InputConfig::OPTION_LONG);
    }
}