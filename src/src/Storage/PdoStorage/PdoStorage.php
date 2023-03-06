<?php

declare(strict_types=1);

namespace App\Storage\PdoStorage;

use App\Storage\PdoStorage\DataMapper\ClientMapper;
use App\Storage\StorageInterface;
use PDO;

class PdoStorage implements StorageInterface
{
    private PDO $pdo;

    public function __construct(private array $config)
    {
        $this->pdo = new PDO($config['dsn']);
    }

    public function testConnection(): string
    {
        $query = sprintf(
            "SELECT 'Successful connection to host %s:%d' as answer",
            $this->config['host'],
            $this->config['port']
        );
        $pdoStatement = $this->pdo->query($query);
        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);
        return $result['answer'];
    }

    public function getClientRepository(): ClientMapper
    {
        return new ClientMapper($this->pdo);
    }
}
