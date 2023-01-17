<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Container;

interface ContainerBuilderInterface
{
    public function build(): Container;
}