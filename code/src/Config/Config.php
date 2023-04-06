<?php

declare(strict_types=1);

namespace Svatel\Code\Config;

final class Config
{
    private array $config;
    public function __construct()
    {
        $configPath = $_SERVER['DOCUMENT_ROOT'] . '/config.ini';
        if (!is_file($configPath)) {
            throw new \Exception('config.ini не найден');
        }

        $this->config = parse_ini_file($configPath);
    }

    public function getForName(string $key): string
    {
        return $this->config[$key];
    }
}
