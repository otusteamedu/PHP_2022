<?php

declare(strict_types=1);

namespace AVasechkin\DataMapper\Application\DataMapper;

use PDO;
use PDOStatement;

class DataMapperPrototype
{
    protected PDO $pdo;

    protected PDOStatement $selectStatement;

    protected PDOStatement $insertStatement;

    protected PDOStatement $updateStatement;

    protected PDOStatement $deleteStatement;

    protected PDOStatement $findAllStatement;

    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }
}
