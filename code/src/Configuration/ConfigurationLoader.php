<?php

declare(strict_types=1);

namespace Nikolai\Php\Configuration;

use Symfony\Component\Yaml\Yaml;

class ConfigurationLoader implements ConfigurationLoaderInterface
{
    public function __construct(private string $configurationFile) {}

    public function load(): array
    {
        return Yaml::parseFile($this->configurationFile);
    }
}