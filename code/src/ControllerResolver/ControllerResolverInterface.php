<?php

namespace Nikolai\Php\ControllerResolver;

interface ControllerResolverInterface
{
    public function resolve(): string;
}