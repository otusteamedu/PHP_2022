<?php

declare(strict_types=1);

namespace App\DesignPatterns\DataMapper;

class HallMapper
{
    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;
    private \PDOStatement $selectAllStmt;

    public function __construct(protected readonly \PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare('SELECT id, title, capacity, created_at FROM halls WHERE id=?');
        $this->selectAllStmt = $this->pdo->prepare('SELECT id, title, capacity, created_at FROM halls');
        $this->insertStmt = $this->pdo->prepare('INSERT INTO halls (id, title, capacity, created_at) VALUES  (?, ?, ?, ?)');
        $this->updateStmt = $this->pdo->prepare('UPDATE halls SET title = ?, capacity = ?, created_at = ? WHERE id=?');
        $this->deleteStmt = $this->pdo->prepare('DELETE FROM halls WHERE id=?');
    }

    public function find(int $id): ?Hall
    {
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return new Hall(
            (int)$result['id'],
            (string)$result['title'],
            (int)$result['capacity'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $result['created_at'])
        );
    }

    /**
     * @return array<Hall>
     */
    public function findAll(): array
    {
        $this->selectAllStmt->execute();
        $result = $this->selectAllStmt->fetchAll(\PDO::FETCH_ASSOC);

        return \array_map(function (array $item) {
            return new Hall(
                (int)$item['id'],
                (string)$item['title'],
                (int)$item['capacity'],
                \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $item['created_at'])
            );
        }, $result);
    }

    public function update(Hall $hall): false|Hall
    {
        if ($this->updateStmt->execute([$hall->getTitle(), $hall->getCapacity(), $hall->getCreatedAt()->format('Y-m-d H:i:s.u'), $hall->getId()])) {
            return $hall;
        }

        return false;
    }

    public function insert(Hall $hall): false|Hall
    {
        if ($this->insertStmt->execute([$hall->getId(), $hall->getTitle(), $hall->getCapacity(), $hall->getCreatedAt()->format('Y-m-d H:i:s.u')])) {
            return $hall;
        }

        return false;
    }

    public function deleteById(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}