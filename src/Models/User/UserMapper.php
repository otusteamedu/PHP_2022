<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Models\User;

use Exception;
use Eliasjump\HwStoragePatterns\Kernel\PDOConnections\MySqlPDO;
use PDO;
use PDOStatement;

class UserMapper
{
    use MySqlPDO;

    private PDOStatement $getById;
    private PDOStatement $getByEmail;
    private PDOStatement $getAll;
    private PDOStatement $insert;
    private PDOStatement $updateById;
    private PDOStatement $delete;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->createPdo();

        $this->getById = $this->pdo->prepare(
            "select * from users where id = ?"
        );

        $this->getByEmail = $this->pdo->prepare(
            "select * from users where email = ?"
        );

        $this->getAll = $this->pdo->prepare(
            "select * from users"
        );

        $this->insert = $this->pdo->prepare(
            "insert into users (name, email) values (?,?)"
        );

        $this->updateById = $this->pdo->prepare(
            "update users set name = ?, email = ? where id = ?"
        );

        $this->delete = $this->pdo->prepare(
            "delete from users where id = ?"
        );
    }

    public function all(): array
    {
        $this->getAll->setFetchMode(PDO::FETCH_ASSOC);
        $this->getAll->execute();
        $res = $this->getAll->fetchAll();

        $users = [];
        foreach ($res as $item)
            $users[] = new User((int) $item['id'], $item['name'], $item['email']);
        return $users;
    }

    public function findById(string $id): User
    {
        $this->getById->setFetchMode(PDO::FETCH_ASSOC);
        $this->getById->execute([$id]);
        $res = $this->getById->fetch();

        return new User(
            (int) $id,
            $res['name'],
            $res['email'],
        );
    }

    public function findByEmail(string $email): User
    {
        $this->getByEmail->setFetchMode(PDO::FETCH_ASSOC);
        $this->getByEmail->execute([$email]);
        $res = $this->getByEmail->fetch();

        return new User(
            (int) $res['id'],
            $res['name'],
            $email,
        );
    }

    public function save(User $user): User
    {
        $this->insert->execute([
            $user->name,
            $user->email,
        ]);

        return $this->findByEmail($user->email);
    }

    public function update(User $user): User
    {
        $this->updateById->execute([
            $user->name,
            $user->email,
            $user->id,
        ]);
        return $user;
    }

    public function destroy(string $id): bool
    {
        return $this->delete->execute([$id]);
    }
}