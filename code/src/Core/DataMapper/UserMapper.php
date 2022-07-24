<?php
declare(strict_types=1);


namespace Decole\Hw15\Core\DataMapper;


use PDO;
use PDOStatement;

class UserMapper
{
    private PDOStatement $selectStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(private PDO $pdo)
    {
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO users (first_name, last_name, email, approved) VALUES (?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE users SET first_name = ?, last_name = ?, email = ?, approved = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM users WHERE id = ?'
        );
    }

    public function findById(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return new User(
            $result['id'],
            $result['first_name'],
            $result['last_name'],
            $result['email'],
            $result['approved'],
        );
    }

    public function insert(array $rawUserData): User
    {
        $this->insertStatement->execute([
            $rawUserData['first_name'],
            $rawUserData['last_name'],
            $rawUserData['email'],
            $rawUserData['approved'],
        ]);

        return new User(
            (int)$this->pdo->lastInsertId(),
            (string)$rawUserData['first_name'],
            (string)$rawUserData['last_name'],
            (string)$rawUserData['email'],
            (bool)$rawUserData['approved'],
        );
    }

    public function update(User $user): bool
    {
        return $this->updateStatement->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->isApproved(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        return $this->deleteStatement->execute([$user->getId()]);
    }
}