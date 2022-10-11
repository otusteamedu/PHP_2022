<?php

namespace Nikolai\Php\Infrastructure\Configuration;

interface ConfigurationInterface
{
    public function load(): void;
}