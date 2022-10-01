<?php

namespace Nikolai\Php\Configuration;

interface ConfigurationLoaderInterface
{
    public function load(): void;
}