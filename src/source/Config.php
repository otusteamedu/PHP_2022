<?php

namespace TemaGo\CommandChat;

class Config
{
    private static function init() : array
    {
        return parse_ini_file('./config.ini');
    }

    public static function getConfig (string $key, $default = null)
    {
        $ini = self::init();
        return $ini[$key] ?? $default;
    }
}
