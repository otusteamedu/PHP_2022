<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Connection;

use PDO;

final class Connection
{
    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return new PDO($_ENV['DB_DSN']);
    }

    private function __clone() {}

    public function __wakeup() {}
}