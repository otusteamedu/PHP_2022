<?php

declare(strict_types = 1);

namespace Study\Cinema\RowGateway;

use Study\Cinema\RowGateway\DaysType;

class DaysTypeFinder {
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select name, rate from days_type where days_type_id = ?"
        );
    }

    public function findById(int $id): DaysType
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new DaysType($this->pdo))
            ->setId($id)
            ->setName($result['name'])
            ->setRate($result['rate'])
            ;
    }
}