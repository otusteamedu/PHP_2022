<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Configuration;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;

class Configuration implements ConfigurationInterface
{
    const MAPPER_FILE = '/config/mapper.yaml';
    private Dotenv $dotenv;

    public function __construct() {
        $this->dotenv = new Dotenv();
    }

    public function load(): array
    {
        $this->dotenv->loadEnv(dirname(__DIR__, 3) . '/.env');
        return Yaml::parseFile(dirname(__DIR__, 3) . self::MAPPER_FILE);
    }
}