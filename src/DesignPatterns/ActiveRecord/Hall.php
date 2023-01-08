<?php

declare(strict_types=1);

namespace App\DesignPatterns\ActiveRecord;

class Hall
{
    public ?int $id;
    public string $title;
    public int $capacity;
    public \DateTimeImmutable $createdAt;

    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    private static $selectQuery = 'SELECT id, title, capacity, created_at FROM halls WHERE id=?';

    public function __construct(protected readonly \PDO $pdo)
    {
        $this->insertStmt = $this->pdo->prepare('INSERT INTO halls (title, capacity, created_at) VALUES  (?, ?, ?)');
        $this->updateStmt = $this->pdo->prepare('UPDATE halls SET title = ?, capacity = ?, created_at = ? WHERE id=?');
        $this->deleteStmt = $this->pdo->prepare('DELETE FROM halls WHERE id=?');
    }

    public static function find(\PDO $pdo, int $id): ?Hall
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        $hall = new self($pdo);
        $hall->id = (int)$result['id'];
        $hall->title = (string)$result['title'];
        $hall->capacity = (int)$result['capacity'];
        $hall->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', $result['created_at']);

        return $hall;
    }

    /**
     * Тупой метод, который нужен только для того, чтобы добавить какую-то бизнес логику, чтобы это был Active Record
     */
    public function isHuge(): bool
    {
        return $this->capacity > 500;
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