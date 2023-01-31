<?php

declare(strict_types=1);

namespace Src\Sandwich\Application\Core;

use DI\Container;
use Src\Sandwich\Application\Core\Bootstrap\DependencyContainer;

final class Core
{
    /**
     * @var DependencyContainer
     */
    private DependencyContainer $dependency_container;

    public function __construct()
    {
        $this->dependency_container = new DependencyContainer();
    }

    /**
     * @throws \Exception
     */
    public function start(): Container
    {
        return $this->dependency_container->createContainer();
    }
}
