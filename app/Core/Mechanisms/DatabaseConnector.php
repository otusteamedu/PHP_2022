<?php

declare(strict_types=1);

namespace App\Core\Mechanisms;

use App\Domain\Contracts\Database\DataBaseConnectionContract;

final class DatabaseConnector implements DataBaseConnectionContract
{
    /**
     * @var string
     */
    private string $dsn;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $password;

    public function __construct()
    {
        $this->dsn = 'pgsql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';';

        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    /**
     * @return \PDO
     */
    public function pdoConnector(): \PDO
    {
        $connection = new \PDO(
            dsn: $this->dsn,
            username: $this->username,
            password: $this->password
        );

        $connection->setAttribute(attribute: \PDO::ATTR_ERRMODE, value: \PDO::ERRMODE_EXCEPTION);

        return $connection;
    }
}
