<?php

namespace Ppro\Hw15\Entity\RowGateway;

class Hall {
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var int
     */
    private int $hall_id;
    /**
     * @var string
     */
    private string $name;

    /**
     * @var false|\PDOStatement
     */
    private $insertStmt;

    /**
     * @var false|\PDOStatement
     */
    private $updateStmt;

    /**
     * @var false|\PDOStatement
     */
    private $deleteStmt;


    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into hall (name) values (?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update hall set name = ? where hal_id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from hall where hall_id = ?");
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->hall_id;
    }

    /**
     * @param int $id
     *
     * @return Hall
     */
    public function setId(int $id): self
    {
        $this->hall_id = $id;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return Hall
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function insert(): int
    {
        $this->insertStmt->execute([
            $this->name
        ]);
        $this->hall_id = $this->pdo->lastInsertId();
        return (int) $this->hall_id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->name,
            $this->hall_id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->hall_id]);
        $this->hall_id = null;
        return $result;
    }
}