<?php

namespace App\Db\Database\IdentityMap\Mapper;

use App\Db\Database\Connector;
use App\Db\Database\IdentityMap\Entity\User;
use App\Db\Database\IdentityMap\IdentityMap\UserIdentityMap;
use WS\Utils\Collections\CollectionFactory;

class UserMapper
{
    private \PDO $pdo;
    private UserIdentityMap $identityMap;

    public function __construct(Connector $connector, UserIdentityMap $identityMap)
    {
        $this->pdo = $connector::connect();
        $this->identityMap = $identityMap;
    }

    public function insert(User $user): int
    {
        $prepare = $this->pdo->prepare('INSERT INTO users (name, surname) VALUES (?, ?)');

        $prepare->execute([
            $user->getName(),
            $user->getSurname(),
        ]);

        return $this->pdo->lastInsertId();
    }

    public function update(User $user): void
    {
        $prepare = $this->pdo->prepare('UPDATE users SET name=?, surname=? WHERE id=?');

        $prepare->execute([
            $user->getName(),
            $user->getSurname(),
            $user->getId(),
        ]);

        $this->identityMap::set($user);
    }

    public function delete(User $user): void
    {
        $prepare = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $prepare->execute([$user->getId()]);
        $this->identityMap::remove($user->getId());
    }

    public function findById(int $id): ?User
    {
        if ($user = $this->identityMap::get($id)) {
            return $user;
        }

        $prepare = $this->pdo->prepare('SELECT id, name, surname FROM users WHERE id = ?');
        $prepare->execute([$id]);
        if (!$result = $prepare->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        }

        $user = User::create()
            ->setId($result['id'])
            ->setName($result['name'])
            ->setSurname($result['surname']);

        $this->identityMap::set($user);

        return $user;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        $count = $this->pdo->query('SELECT id FROM users')->rowCount();

        if ($count === $this->identityMap::count()) {
            return $this->identityMap::getAll();
        }

        $prepare = $this->pdo->query('SELECT id, name, surname FROM users', \PDO::FETCH_ASSOC);

        return CollectionFactory::fromIterable($prepare)
            ->stream()
            ->map(function (array $row) {
                $user = User::create()
                    ->setId($row['id'])
                    ->setName($row['name'])
                    ->setSurname($row['surname']);

                $this->identityMap::set($user);

                return $user;
            })
            ->toArray();
    }
}
