<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use Core\Storage\Contract\StorageClientInterface;
use App\User\Domain\Model\UserModel;
use App\User\Application\Contract\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $client;

    public function __construct(StorageClientInterface $client)
    {
        $this->client = $client;
    }

    public function create(UserModel $user): int
    {
        $this->client->query(
            "
            INSERT INTO user 
            SET 
                email = '" . $this->client->escape($user->getEmail()->getValue()) . "', 
                phone = '" . $this->client->escape($user->getPhone()->getValue()) . "', 
                age = " . (int)$user->getAge()->getValue()
        );

        return $this->client->getLastId();
    }

    public function findOne(int $id): UserModel
    {
        $query = $this->client->query("SELECT id, email, phone, age FROM user WHERE id = $id");

        if ($query->getNumRows()) {
            $user = $query->getOne();
            $model = new UserModel(
                $user['email'],
                $user['phone'],
                (int)$user['age'],
                (int)$user['id']
            );
            return $model;
        } else {
            throw new \Exception("User with id = $id not found.");
        }
    }

    public function getAll(): array
    {
        $query = $this->client->query("SELECT id, email, phone, age FROM user");

        if ($query->getNumRows()) {
            $users = $query->getAll();
            $result = [];
            foreach ($users as $user) {;
                $result[] = new UserModel(
                    $user['email'],
                    $user['phone'],
                    (int)$user['age'],
                    (int)$user['id']
                );
            }
            return $result;
        } else {
            throw new \Exception("Users not found.");
        }
    }

    public function update(UserModel $user): int
    {
        $current_user = $this->findOne($user->getId());

        $implode_sql = [];

        if ($current_user->getEmail() !== $user->getEmail()) {
            $implode_sql[] = "email = '" . $this->client->escape($user->getEmail()->getValue()) . "'";
        }

        if ($current_user->getPhone() !== $user->getPhone()) {
            $implode_sql[] = "phone = '" . $this->client->escape($user->getPhone()->getValue()) . "'";
        }

        if ($current_user->getAge() !== $user->getAge()) {
            $implode_sql[] = "age = '" . $user->getAge()->getValue() . "'";
        }

        if ($implode_sql) {
            $sql = "UPDATE user SET " . implode(', ', $implode_sql) . " WHERE id = " . (int)$user->getId();
            $this->client->query($sql);
            return $this->client->countAffected();
        }

        return 0;
    }

    public function delete(int $id): int
    {
        $this->client->query("DELETE FROM user WHERE id = $id");

        return $this->client->countAffected();
    }
}
