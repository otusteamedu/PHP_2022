<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Configuration;

use Symfony\Component\Dotenv\Dotenv;

class Configuration implements ConfigurationInterface
{
    private Dotenv $dotenv;

    public function __construct() {
        $this->dotenv = new Dotenv();
    }

    public function load(): void
    {
        $this->dotenv->loadEnv(dirname(__DIR__, 3) . '/.env');
    }
}