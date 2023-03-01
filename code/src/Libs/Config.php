<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Libs;

class Config
{
    public const CONFIG_PATH = ROOT . "/src/config/config.ini";

    /**
     * @param $key
     * @return mixed
     */
    public static function getOption($key): mixed
    {
        $config = parse_ini_file(self::CONFIG_PATH);

        return $config[$key];
    }
}