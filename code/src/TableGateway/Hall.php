<?php

declare(strict_types = 1);

namespace Study\Cinema\TableGateway;
use PDO;

class Hall {
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param \PDO $pdo
     */
    private string $params;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->params = '';
        $this->selectStmt = $pdo->prepare(
            "select name, rate, seats_number from hall where hall_id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into hall(name, rate, seats_number,  created_at, updated_at) values (?, ?, ?,  now(), now())"
        );
        /*
        $this->updateStmt = $pdo->prepare(
            "update hall set ".$this->params." updated_at = now() where id = ?"
        );
        */
        $this->deleteStmt = $pdo->prepare("delete from hall where hall_id = ?");

    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getById(int $id): array
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        return (array) $this->selectStmt->fetch();
    }

    /**
     * @param string $name
     * @param float $rate
     * @param int $seats_number
     *
     * @return int
     */
    public function insert(string $name, float $rate, int $seats_number): int
    {
        $this->insertStmt->execute([
            $name,
            $rate,
            $seats_number,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param string $name
     * @param float $rate
     * @param int $seats_number
     *
     * @return bool
     */
    public function update(int $id, string $name = null, float $rate = null, int $seats_number = null): bool
    {
        $updateParams = $this->prepareUpdateParams($name, $rate, $seats_number);
        if(!$updateParams)
            return false;

        $this->updateStmt = $this->pdo->prepare(
            "update hall set ".$updateParams." updated_at = now() where hall_id = :id"
        );

        if(isset($name))
            $this->updateStmt->bindParam(':name', $name, PDO::PARAM_STR);
        if(isset($rate))
            $this->updateStmt->bindParam(':rate', $rate);
        if(isset($seats_number))
            $this->updateStmt->bindParam(':seats_number', $seats_number, PDO::PARAM_INT);
        $this->updateStmt->bindParam(':id', $id, PDO::PARAM_INT);


        $this->updateStmt->setFetchMode(\PDO::FETCH_ASSOC);


        return $this->updateStmt->execute();

    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }

    private function prepareUpdateParams(string $name = null, float $rate = null, int $seats_number = null): string
    {
        $updateParams = '';
        if(isset($name))
            $updateParams .= " name = :name, ";
        if(isset($rate))
            $updateParams.= " rate = :rate, ";
        if(isset($seats_number))
            $updateParams.= " seats_number = :seats_number, ";

        return $updateParams;
    }
}

