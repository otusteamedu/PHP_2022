<?php

declare(strict_types=1);

namespace Src\Application\Bootstrap;

use DI\Container;
use DI\ContainerBuilder;

final class Configurator
{
    /**
     * @return Container
     * @throws \Exception
     */
    public function initialize(): Container
    {
        $container_builder = new ContainerBuilder();

        $container_builder->addDefinitions(__DIR__ . '/../config/common.php');

        return $container_builder->build();
    }
}
