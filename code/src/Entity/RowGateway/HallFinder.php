<?php

namespace Ppro\Hw15\Entity\RowGateway;;

use Ppro\Hw15\Entity\RowGateway\Hall;

class HallFinder {
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
            "select name from hall where hall_id = ?"
        );
    }

    /**
     * @param int $id
     *
     * @return Hall
     */
    public function findById(int $id): Hall
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new Hall($this->pdo))
            ->setId($id)
            ->setName($result['name']);
    }
}