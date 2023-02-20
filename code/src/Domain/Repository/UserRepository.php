<?php
namespace Study\Cinema\Domain\Repository;

use PDO;
use PDOStatement;
use Study\Cinema\Domain\User;

class UserRepository
{

    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("select * from \"user\" where user_id = ?");
        $this->insertStmt = $pdo->prepare("insert into user (name) values (?)");
        $this->updateStmt = $pdo->prepare("update user set name = ? where user_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from user where user_id = ?");
    }

    public function findById($id) : User
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();
        $user = new User();
        $user->setId($result['user_id']);
        $user->setName($result['name']);

        return $user ;
    }

    public function insert(User $user): int
    {
        $this->insertStmt->execute([$user->getName()]);
        $user->setId( (int) $this->pdo->lastInsertId());
        return (int) $user->getId();
    }

    public function update(User $user): bool
    {
        return $this->updateStmt->execute([ $user->getName()]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStmt->execute([$id]);
        //$this->id = null;
        return $result;
    }
}



