<?php

namespace Otus\Core\Database;

use PDO;

class DBConnection
{
    private ?PDO $pdo = null;
    private static $instance = null;

    private function __construct()
    {
    }

    public static function connect(): ?PDO
    {
        $instance = self::getInstance();
        return $instance->getPDO();
    }

    public static function setOptions(
        string $dsn,
        string $user,
        string $password,
    ): void
    {
        $instance = self::getInstance();
        $instance->pdo = new PDO($dsn, $user, $password,);
    }

    public function getPDO(): ?PDO
    {
        return $this->pdo;
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