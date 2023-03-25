<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Config;

class Config
{
    private $config;

    public function __construct()
    {
        $config_path = $_SERVER['DOCUMENT_ROOT'] . '/config.ini';
        if (!is_file($config_path)) {
            throw new \Exception('config.ini not found');
        }
        $this->config = parse_ini_file($config_path);
    }

    public function get($key): string
    {
        return $this->config[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }
}
