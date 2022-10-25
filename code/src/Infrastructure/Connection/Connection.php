<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Connection;

final class Connection
{
    const DSN_HOST      = 'host=';
    const DSN_PORT      = 'port=';
    const DSN_DB_NAME   = 'dbname=';
    const DSN_USER      = 'user=';
    const DSN_PASSWORD  = 'password=';
    const DSN_DELIMITER = ';';
    const DSN_COLON     = ':';

    private static ?self $instance = null;

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        return new \PDO($this->getDsn());
    }

    public function __wakeup() {}

    private function __clone() {}

    private function getDsn(): string
    {
        return $_ENV['DB_DRIVER'] . self::DSN_COLON .
            self::DSN_HOST . $_ENV['DB_HOST'] . self::DSN_DELIMITER .
            self::DSN_PORT . $_ENV['DB_PORT'] . self::DSN_DELIMITER .
            self::DSN_DB_NAME . $_ENV['DB_NAME'] . self::DSN_DELIMITER .
            self::DSN_USER . $_ENV['DB_USER'] . self::DSN_DELIMITER .
            self::DSN_PASSWORD . $_ENV['DB_PASSWORD'];
    }
}