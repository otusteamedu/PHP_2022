<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Libs\Core\DI;

use DI\ContainerBuilder;
use DI\Container;

class DIContainer
{
    public static function build(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(ROOT . "/src/config/definitions.php");

        return $builder->build();
    }
}