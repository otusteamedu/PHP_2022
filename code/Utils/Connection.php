<?php

declare(strict_types=1);

namespace App\Utils;

use PDO;
use PDOException;

class Connection
{
    private PDO $connection;

    private array $credentials;

    public function __construct(string $db_host, string $db_name, string $db_username, string $db_password)
    {
        $this->credentials = [
            'host' => $db_host,
            'db' => $db_name,
            'user' => $db_username,
            'pass' => $db_password,
        ];
    }

    public function setConnection(): PDO
    {
        $dsn = 'pgsql:host='.$this->credentials['host'].';dbname='.$this->credentials['db'].';';

        try {
            $this->connection = new PDO(
                $dsn,
                $this->credentials['user'],
                $this->credentials['pass'],
            );

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage(), "\n";
        }

        return $this->connection;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}