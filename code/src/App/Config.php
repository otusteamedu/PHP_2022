<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\App;

class Config
{
    const CONFIG_PATH = ROOT . "/config.ini";

    /**
     * @param $key
     * @return mixed
     */
    public static function getOption($key)
    {
        $config = parse_ini_file(self::CONFIG_PATH);

        return $config[$key];
    }

    /**
     * @return string
     */
    public static function getStringFromArray($key): string
    {
        return implode("|", self::getOption($key));
    }
}