<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Container;

interface ContainerBuilderInterface
{
    public function build(): Container;
}