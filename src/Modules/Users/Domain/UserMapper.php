<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Domain;

use Eliasjump\HwStoragePatterns\App\Kernel\PDOConnections\MySqlPDO;
use Exception;
use PDO;
use PDOStatement;

class UserMapper
{
    use MySqlPDO;

    private PDOStatement $getById;
    private PDOStatement $getByEmail;
    private PDOStatement $getAll;
    private PDOStatement $insert;
//    private PDOStatement $updateById;
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
            $users[] = new User((int)$item['id'], $item['name'], $item['email']);
        return $users;
    }

    public function findById(string $id): User
    {
        $this->getById->setFetchMode(PDO::FETCH_ASSOC);
        $this->getById->execute([$id]);
        $res = $this->getById->fetch();

        return new User(
            (int)$id,
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
            (int)$res['id'],
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
        $this->updateQueryConstructor($user)->execute();
        return $this->findById((string)$user->id);
    }

    public function destroy(string $id): bool
    {
        return $this->delete->execute([$id]);
    }

    private function updateQueryConstructor(User $user): PDOStatement
    {
        $query = ["update users set"];

        $queryParams = [];
        if ($user->name !== '') {
            $queryParams[] = "name = '{$user->name}'";
        }
        if ($user->email !== '') {
            $queryParams[] = "email = '{$user->email}'";
        }

        $query[] = implode(', ', $queryParams);
        $query[] = "where id = $user->id";

        $query = implode(' ', $query);

        return $this->pdo->prepare($query);

    }
}