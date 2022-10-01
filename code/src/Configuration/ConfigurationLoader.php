<?php

declare(strict_types=1);

namespace Nikolai\Php\Configuration;

use Symfony\Component\Dotenv\Dotenv;

class ConfigurationLoader implements ConfigurationLoaderInterface
{
    private Dotenv $dotenv;

    public function __construct() {
        $this->dotenv = new Dotenv();
    }

    public function load(): void
    {
        $this->dotenv->loadEnv(dirname(__DIR__, 2) . '/.env');
    }
}