<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Service;

class Registry
{
    private static $instance = null;
    private $registry = [];

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(string $key): object
    {
        return $this->registry[$key] ?? null;
    }

    public function set(string $key, object $value): void
    {
        $this->registry[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->registry[$key]);
    }
}
