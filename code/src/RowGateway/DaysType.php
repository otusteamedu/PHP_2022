<?php

declare(strict_types = 1);

namespace Study\Cinema\RowGateway;

class DaysType {
    /**
     * @var \PDO
     */
    private $pdo;

    private ?int $id;
    private string $name;
    private float $rate;


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
    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare("insert into days_type (name, rate,  created_at, updated_at) values (?, ?, now(), now())");
        $this->updateStmt = $pdo->prepare("update days_type set name = ?, rate = ?, updated_at = now() where days_type_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from days_type where days_type_id = ?");
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DaysType
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return DaysType
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return DaysType
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function insert(): int
    {
        $this->insertStmt->execute([
            $this->name,
            $this->rate,

        ]);
        $this->id = (int) $this->pdo->lastInsertId();
        return (int) $this->id;
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->name,
            $this->rate,
            $this->id
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->id]);
        $this->id = null;
        return $result;
    }
}