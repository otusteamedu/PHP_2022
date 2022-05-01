<?php

namespace App\Ddd;

use DI\Container;
use DI\ContainerBuilder;

class ContainerFactory
{
    public static function getContainer(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($_ENV['HOME']. '/' . $_ENV['di_config']);
        return $builder->build();
    }
}