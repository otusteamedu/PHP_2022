<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Config;

use \Nsavelev\Hw6\Services\Config\Configs\Extensions\Php\Config as ConfigExtensionPhp;
use Nsavelev\Hw6\Services\Config\Interfaces\ConfigInterface;

class Config
{
    /**
     * @return ConfigInterface
     */
    public static function getInstance(): ConfigInterface
    {
        $config = ConfigExtensionPhp::getInstance();

        return $config;
    }
}