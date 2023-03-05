<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Storage;

use DKozlov\Otus\Application;
use DKozlov\Otus\Domain\Storage\StorageInterface;
use DKozlov\Otus\Exception\ConnectionTimeoutException;
use PDO;
use PDOException;

class Storage implements StorageInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = $this->constructPDO();
    }

    public function select(string $query, array $params): array
    {
        try {
            $statement = $this->pdo->prepare($query);

            $statement->execute($params);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            throw new ConnectionTimeoutException($exception->getMessage());
        }
    }

    public function insert(string $query, array $params): void
    {
        try {
            $statement = $this->pdo->prepare($query);

            $statement->execute($params);
        } catch (PDOException $exception) {
            throw new ConnectionTimeoutException($exception->getMessage());
        }
    }

    public function update(string $query, array $params): void
    {
        try {
            $statement = $this->pdo->prepare($query);

            $statement->execute($params);
        } catch (PDOException $exception) {
            throw new ConnectionTimeoutException($exception->getMessage());
        }
    }

    public function delete(string $query, array $params): void
    {
        try {
            $statement = $this->pdo->prepare($query);

            $statement->execute($params);
        } catch (PDOException $exception) {
            throw new ConnectionTimeoutException($exception->getMessage());
        }
    }

    private function constructPDO(): PDO
    {
        $dsn = 'pgsql:host=' . Application::config('DB_HOST') . ';';
        $dsn .= 'port=' . Application::config('DB_PORT') . ';';
        $dsn .= 'dbname=' . Application::config('DB_NAME');

        return new PDO(
            $dsn,
            Application::config('DB_USERNAME'),
            Application::config('DB_PASSWORD')
        );
    }
}