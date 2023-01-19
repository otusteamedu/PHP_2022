<?php

namespace Cookapp\Php\Infrastructure\ControllerResolver;

/**
 * ControllerResolverInterface
 */
interface ControllerResolverInterface
{
    /**
     * @return string
     */
    public function resolve(): string;
}
