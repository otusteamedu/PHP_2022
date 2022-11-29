<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\App;

class Config
{
    const SOCK_FILE_NAME = "chat.sock";
    const APP_NAMESPACE = "Nikcrazy37\Hw6\App\\";
    const APP_NAME = array('server', 'client');

    public static function getAppNameString()
    {
        return implode("|", self::APP_NAME);
    }
}