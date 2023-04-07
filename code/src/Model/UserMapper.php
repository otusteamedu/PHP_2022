<?php

declare(strict_types=1);

namespace Svatel\Code\Model;

use PDO;
use Svatel\Code\Config\Config;

final class UserMapper
{
    private Config $config;
    private PDO $client;

    public function __construct()
    {
        $this->config = new Config();
        $this->client = new PDO(
            'mysql:host=host.docker.internal;dbname=' . $this->config->getForName('db_name'),
            $this->config->getForName('db_user'),
            $this->config->getForName('db_password')
        );
    }

    public function create(User $user): bool
    {
        try {
            $query = "INSERT INTO `users` (`id` , `name`, `email`, `number`) VALUES (:id, :name, :email, :number)";
            $params = [
                ':id' => $user->getId(),
                ':name' => $user->getName(),
                ':email' => $user->getEmail(),
                ':number' => $user->getNumber()
            ];
            $stmt = $this->client->prepare($query);
            $stmt->execute($params);
            return true;
        } catch (\Exception $e) {
            print_r($e->getMessage());
            return false;
        }
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->client->prepare("SELECT * FROM users WHERE `id` = ?");
        $stmt->execute([$id]);
        $userArray = $stmt->fetch(PDO::FETCH_LAZY);

        if (empty($userArray)) {
            return null;
        }

        $user = new User();
        $user->setId((int) $userArray['id']);
        $user->setName($userArray['name']);
        $user->setEmail($userArray['email']);
        $user->setNumber($userArray['number']);

        return $user;
    }

    public function update(User $userUpd): bool
    {
        $user = $this->findById($userUpd->getId());

        if (is_null($user)) {
            return false;
        }

        $updateFields = [];

        if ($user->getName() != $userUpd->getName()) {
            $updateFields[':name'] = [$userUpd->getName()];
        }

        if ($user->getEmail() != $userUpd->getEmail()) {
            $updateFields[':email'] = [$userUpd->getEmail()];
        }

        if ($user->getNumber() != $userUpd->getNumber()) {
            $updateFields[':number'] = [$userUpd->getNumber()];
        }

        if (!empty($updateFields)) {
            $res = '';
            $params = [
                ':id' => $userUpd->getId(),
            ];
            if (count($updateFields) == 1) {
                if (isset($updateFields['name'])) {
                    $res = "`name` = :name";
                    $params[':name'] = $updateFields['name'];
                }
                if (isset($updateFields['email'])) {
                    $res = "`email` = :email";
                    $params[':email'] = $updateFields['email'];
                }
                if (isset($updateFields['number'])) {
                    $res = "`number` = :number";
                    $params[':number'] = $updateFields['number'];
                }
            } else {
                $count = 0;
                foreach ($updateFields as $key => $value) {
                    $count++;
                    $params[$key] = $value[0];
                    $fixParam = trim($key, ':');
                    if ($count != count($updateFields)) {
                        $res .= '`' . $fixParam . '` = :' . $fixParam . ', ';
                    } else {
                        $res .= '`' . $fixParam . '` = :' . $fixParam . ' ';
                    }
                }
            }

            $query = "UPDATE `users` SET " . $res . "WHERE `id` = :id";
            $stmt = $this->client->prepare($query);
            $stmt->execute($params);
        }

        return true;
    }

    public function delete(User $user): bool
    {
        $query = "DELETE FROM `users` WHERE `id` = ?";
        $params = [$user->getId()];
        $stmt = $this->client->prepare($query);
        $stmt->execute($params);

        return true;
    }
}
