<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Configuration;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;

/**
 * Config
 */
class Configuration
{
    const CONFIG_FILE = '/config/services.yaml';
    private Dotenv $dotenv;

    /**
     * Init
     */
    public function __construct()
    {
        $this->dotenv = new Dotenv();
    }

    /**
     * Read .env file
     * @return array
     */
    public function load(): array
    {
        $this->dotenv->loadEnv(dirname(__DIR__, 3) . '/.env');
        return Yaml::parseFile(dirname(__DIR__, 3) . self::CONFIG_FILE);
    }
}
