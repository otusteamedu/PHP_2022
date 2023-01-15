<?php

declare(strict_types=1);

namespace App\DesignPatterns\RowDataGateway;

class Hall
{
    public ?int $id;
    public string $title;
    public int $capacity;
    public \DateTimeImmutable $createdAt;

    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    public function __construct(protected readonly \PDO $pdo)
    {
        $this->insertStmt = $this->pdo->prepare('INSERT INTO halls (title, capacity, created_at) VALUES  (?, ?, ?)');
        $this->updateStmt = $this->pdo->prepare('UPDATE halls SET title = ?, capacity = ?, created_at = ? WHERE id=?');
        $this->deleteStmt = $this->pdo->prepare('DELETE FROM halls WHERE id=?');
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->title,
            $this->capacity,
            $this->createdAt->format('Y-m-d H:i:s.u'),
            $this->id
        ]);
    }

    public function insert(Hall $hall): false|int
    {
        if ($this->insertStmt->execute([$hall->title, $hall->capacity, $hall->createdAt->format('Y-m-d H:i:s.u')])) {
            $this->id = (int)$this->pdo->lastInsertId();
            return $this->id;
        }

        return false;
    }

    public function deleteById(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}