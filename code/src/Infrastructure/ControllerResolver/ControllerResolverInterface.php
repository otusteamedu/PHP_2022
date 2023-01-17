<?php

namespace Cookapp\Php\Infrastructure\ControllerResolver;

interface ControllerResolverInterface
{
    public function resolve(): string;
}