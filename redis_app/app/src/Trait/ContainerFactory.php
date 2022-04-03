<?php

namespace Redis\App\Trait;

use DI\Container;
use DI\ContainerBuilder;

trait ContainerFactory
{
    public function getContainer(): Container
    {
        $builder = new ContainerBuilder();
        return $builder->build();
    }
}