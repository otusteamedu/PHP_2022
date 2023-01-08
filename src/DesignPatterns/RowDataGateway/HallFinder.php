<?php

declare(strict_types=1);

namespace App\DesignPatterns\RowDataGateway;

class HallFinder
{
    private \PDOStatement $selectStmt;

    public function __construct(protected readonly \PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare('SELECT id, title, capacity, created_at FROM halls WHERE id=?');
    }

    public function find(int $id): ?Hall
    {
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $hall = new Hall($this->pdo);
        $hall->id = (int)$result['id'];
        $hall->title = (string)$result['title'];
        $hall->capacity = (int)$result['capacity'];
        $hall->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $result['created_at']);

        return $hall;
    }
}