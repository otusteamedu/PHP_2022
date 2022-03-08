<?php

declare(strict_types=1);

namespace masteritua\Socket;

use Dotenv\Dotenv;

class Config
{
    private const CONFIG_FILE = 'config.ini';

    /**
     * @var null[]|string[]
     */
    private array $config;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../config/', self::CONFIG_FILE);
        $this->config = $dotenv->load();
    }

    public function getParam(string $param, $default = null): ?string
    {
        return $this->config[$param] ?? $default;
    }
}