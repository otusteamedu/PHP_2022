<?php

namespace Otus\App\Application\Entity;

class ConfiguratorDB
{
    public static function getConfigBD()
    {
        if (!file_exists('/data/mysite.local/src/Config/config_bd.php')) {
            return false;
        } else {
            return include('/data/mysite.local/src/Config/config_bd.php');
        }
    }
}