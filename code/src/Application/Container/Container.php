<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Container;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    public function __construct(private ContainerInterface $container) {}

    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}