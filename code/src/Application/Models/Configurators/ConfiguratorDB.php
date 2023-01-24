<?php

namespace Otus\Mvc\Application\Models\Configurators;

class ConfiguratorDB
{
    public static function getConfigBD()
    {
        if (!file_exists(__DIR__ . '/../../../config/config_bd.php')) {
            return false;
        } else {
            return include(__DIR__ . '/../../../config/config_bd.php');
        }
    }
}