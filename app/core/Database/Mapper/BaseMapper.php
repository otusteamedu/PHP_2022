<?php

namespace Otus\Core\Database\Mapper;

use Otus\Core\Database\Exception\DBSQLNotFoundException;
use PDO;
use Otus\Core\Database\DBConnection;

class BaseMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::connect();
    }

    private function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function fetchAll(
        string $query,
        array  $params = [],
        array  $options = [],
    ): array
    {
        $options = $this->mergeOptions($options);
        $stmt = $this->getPdo()->prepare($query, $options['prepare']);
        $stmt->execute($params);
        return $stmt->fetchAll(...$options['fetchAll']);
    }

    public function fetch(
        string $query,
        array  $params = [],
        array  $options = [],
    ): array
    {
        $options = $this->mergeOptions($options);
        $stmt = $this->getPdo()->prepare($query, $options['prepare']);
        $stmt->execute($params);
        $row = $stmt->fetch(...$options['fetch']);
        $stmt->closeCursor();
        if (empty($row)) {
            $strParams = implode(', ', $params);
            throw new DBSQLNotFoundException("Result does not exist for SQL: $query, params: $strParams");
        }
        return $row;
    }

    public function executeQuery(
        array  $data,
        string $query,
        array  $options = [],
    ): void
    {
        $options = $this->mergeOptions($options);
        $stmt = $this->getPdo()->prepare($query, $options['prepare']);
        $stmt->execute($data);
    }

    public function getLastInsertId(): int
    {
        return $this->getPdo()->lastInsertId();
    }

    private function mergeOptions(array $options = []): array
    {
        return array_merge_recursive([
            'fetch' => [
                'mode' => PDO::FETCH_ASSOC,
                'cursorOrientation' => PDO::FETCH_ORI_NEXT,
                'cursorOffset' => 0
            ],
            'fetchAll' => [
                'mode' => PDO::FETCH_ASSOC,
                'fetch_argument' => null,
            ],
            'prepare' => [],
        ], $options);
    }
}