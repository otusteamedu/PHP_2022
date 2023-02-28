<?php

namespace Email\App\Components;

use DI\Container;
use DI\ContainerBuilder;

class ContainerDI
{
    public static function getContainer(): Container
    {
        $builder = new ContainerBuilder();
        return $builder->build();
    }
}
