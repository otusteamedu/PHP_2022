<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Infrastracture\Storage;

use Dkozlov\Otus\Application;
use Dkozlov\Otus\Application\Interface\StorageInterface;
use Dkozlov\Otus\Exception\ConnectionTimeoutException;
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
        $dsn = 'pgsql:host=' . Application::config('db_host') . ';';
        $dsn .= 'port=' . Application::config('db_port') . ';';
        $dsn .= 'dbname=' . Application::config('db_name');

        return new PDO(
            $dsn,
            Application::config('db_username'),
            Application::config('db_password')
        );
    }
}