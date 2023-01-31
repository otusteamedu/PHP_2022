<?php

declare(strict_types=1);

namespace Src\Sandwich\Application\Core\Bootstrap;

use DI\{Container, ContainerBuilder};

final class DependencyContainer
{
    public function __construct()
    {
        //
    }

    /**
     * @return Container
     * @throws \Exception
     */
    public function createContainer(): Container
    {
        $dependency_container = new ContainerBuilder();

        $dependency_container->addDefinitions(__DIR__ . '/../Configuration/dependency_injection.php');

        return $dependency_container->build();
    }
}
