<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10;

class Config
{
    const CONFIG_PATH = ROOT . "/config.ini";

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