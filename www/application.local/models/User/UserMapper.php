<?php
declare(strict_types=1);
namespace app\models\User;

use app\pdoAdapters\Postgres;

class UserMapper {
    use Postgres;
    private \PDO $pdo;
    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    public function __construct()
    {
        $this->pdo = $this->createPdo();

        $this->selectStmt = $this->pdo->prepare(
            "select name, surname from users where id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "insert into users (id, name, surname) values (?, ?, ?)"
        );
        $this->updateStmt = $this->pdo->prepare(
            "update users set name = ?, surname = ? where id = ?"
        );
        $this->deleteStmt = $this->pdo->prepare("delete from users where id = ?");
    }

    public function findById(string $id): User
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new User(
            $id,
            $result['name'],
            $result['surname'],
        );
    }

    public function insert(array $userData): User
    {
        $this->insertStmt->execute([
            $userData['id'],
            $userData['name'],
            $userData['surname'],
        ]);

        return new User(
            $userData['id'],
            $userData['name'],
            $userData['surname'],
        );
    }

    public function update(User $user): bool
    {
        return $this->updateStmt->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getId(),
        ]);
    }

    public function delete(User $user): bool
    {
        return $this->deleteStmt->execute([$user->getId()]);
    }
}
