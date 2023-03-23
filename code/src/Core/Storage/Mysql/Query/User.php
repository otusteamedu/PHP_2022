<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Mysql\Query;

use Kogarkov\Es\Core\Storage\Mysql\Core;
use Kogarkov\Es\Model\UserModel;

class User
{
    private $client;

    public function __construct()
    {
        $this->client = new Core;
    }

    public function create(UserModel $user): int
    {
        $this->client->query("
            INSERT INTO user 
            SET 
                email = '" . $this->client->escape($user->getEmail()) . "', 
                phone = '" . $this->client->escape($user->getPhone()) . "', 
                age = " . (int)$user->getAge()
        );

        return $this->client->getLastId();
    }

    public function findOne(int $id): UserModel
    {
        $query = $this->client->query("SELECT id, email, phone, age FROM user WHERE id = $id");

        if ($query->getNumRows()) {
            $user = $query->getOne();
            $model = new UserModel();
            $model
                ->setId($user['id'])
                ->setEmail($user['email'])
                ->setPhone($user['phone'])
                ->setAge($user['age']);
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
            foreach ($users as $user) {
                $model = new UserModel();
                $model
                    ->setId($user['id'])
                    ->setEmail($user['email'])
                    ->setPhone($user['phone'])
                    ->setAge($user['age']);
                $result[] = $model;
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
            $implode_sql[] = "email = '" . $this->client->escape($user->getEmail()) . "'";
        }

        if ($current_user->getPhone() !== $user->getPhone()) {
            $implode_sql[] = "phone = '" . $this->client->escape($user->getPhone()) . "'";
        }

        if ($current_user->getAge() !== $user->getAge()) {
            $implode_sql[] = "age = '" . $user->getAge() . "'";
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
