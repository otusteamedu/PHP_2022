<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use Psr\Container\ContainerInterface;

abstract class AbstractCommand implements CommandInterface, ContainerAwareInterface
{
    protected ContainerInterface $container;

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }
}