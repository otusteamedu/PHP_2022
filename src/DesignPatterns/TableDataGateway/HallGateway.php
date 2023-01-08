<?php

declare(strict_types=1);

namespace App\DesignPatterns\TableDataGateway;

class HallGateway
{
    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    public function __construct(protected readonly \PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare('SELECT id, title, capacity, created_at FROM halls WHERE id=?');
        $this->insertStmt = $this->pdo->prepare('INSERT INTO halls (title, capacity, created_at) VALUES  (?, ?, ?)');
        $this->updateStmt = $this->pdo->prepare('UPDATE halls SET title = ?, capacity = ?, created_at = ? WHERE id=?');
        $this->deleteStmt = $this->pdo->prepare('DELETE FROM halls WHERE id=?');
    }

    public function find(int $id): ?HallDTO
    {
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $hall = new HallDTO();
        $hall->id = (int)$result['id'];
        $hall->title = (string)$result['title'];
        $hall->capacity = (int)$result['capacity'];
        $hall->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $result['created_at']);

        return $hall;
    }

    public function update(HallDTO $hall): false|HallDTO
    {
        if ($this->updateStmt->execute([$hall->title, $hall->capacity, $hall->createdAt->format('Y-m-d H:i:s.u'), $hall->id])) {
            return $hall;
        }

        return false;
    }

    public function insert(HallDTO $hall): false|HallDTO
    {
        if ($this->insertStmt->execute([$hall->title, $hall->capacity, $hall->createdAt->format('Y-m-d H:i:s.u')])) {
            $hall->id = (int)$this->pdo->lastInsertId();
            return $hall;
        }

        return false;
    }

    public function deleteById(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}