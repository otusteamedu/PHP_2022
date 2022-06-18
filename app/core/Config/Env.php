<?php

namespace Otus\Core\Config;

use Symfony\Component\Dotenv\Dotenv;

class Env
{
    private static $instance = null;
    private array $env = [];

    private function __construct()
    {
    }

    public static function get(string $key, $default = null)
    {
        $instance = self::getInstance();
        if ($instance->hasKey($key)) {
            return $instance->getValue($key);
        }
        return $default;
    }

    public static function loadFromEnv(string $path): void
    {
        $instance = self::getInstance();
        $dotenv = new Dotenv();
        $dotenv->load($path);
        $keys = explode(',', $_ENV['SYMFONY_DOTENV_VARS']);
        array_map(fn($key) => $instance->env[$key] = $_ENV[$key], $keys);
    }

    public function getValue(string $key)
    {
        return $this->env[$key];
    }

    public function hasKey(string $key): bool
    {
        return key_exists($key, $this->env);
    }

    private static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone()
    {
    }
}