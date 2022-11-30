<?php

namespace Nikolai\Php\Infrastructure\ControllerResolver;

interface ControllerResolverInterface
{
    public function resolve(): string;
}