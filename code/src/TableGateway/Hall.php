<?php

declare(strict_types = 1);

namespace Study\Cinema\TableGateway;

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
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select name, rate, seats_number from hall where hall_id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into hall(name, rate, seats_number,  created_at, updated_at) values (?, ?, ?,  now(), now())"
        );
        $this->updateStmt = $pdo->prepare(
            "update hall set name = ?, rate = ?, eats_number = ?, updated_at = now() where id = ?"
        );
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
     * @param string $seats_number
     *
     * @return bool
     */
    public function update(
        int $id,
        string $name,
        float $rate,
        string $seats_number,

    ): bool {
        $this->updateStmt->setFetchMode(\PDO::FETCH_ASSOC);
        return $this->updateStmt->execute([
            $name,
            $rate,
            $seats_number,
            $id
        ]);
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
}

