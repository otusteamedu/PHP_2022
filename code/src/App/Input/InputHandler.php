<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Input;

use Nikcrazy37\Hw10\Config;

class InputHandler
{
    /**
     * @return array|bool
     */
    public static function getParam(): array|bool
    {
        return getopt("", Config::getOption("OPTION_LONG"));
    }
}