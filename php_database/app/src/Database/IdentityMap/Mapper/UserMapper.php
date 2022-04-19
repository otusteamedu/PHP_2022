<?php

namespace App\Db\Database\IdentityMap\Mapper;

use App\Db\Database\IdentityMap\Entity\User;
use App\Db\Database\IdentityMap\IdentityMap\UserIdentityMap;
use App\Db\Database\QueryBuilder;
use WS\Utils\Collections\CollectionFactory;

class UserMapper
{
    private QueryBuilder $queryBuilder;
    private UserIdentityMap $identityMap;

    public function __construct(QueryBuilder $queryBuilder, UserIdentityMap $identityMap)
    {
        $this->queryBuilder = $queryBuilder;
        $this->identityMap = $identityMap;
    }

    public function insert(User $user): int
    {
        return $this->queryBuilder
            ->table('users')
            ->insert($user);
    }

    public function update(User $user): void
    {
        $this->queryBuilder
            ->table('users')
            ->update($user);

        $this->identityMap::set($user);
    }

    public function delete(User $user): void
    {
        $this->queryBuilder
            ->table('users')
            ->delete($user);

        $this->identityMap::remove($user->getId());
    }

    public function findById(int $id): ?User
    {
        if ($user = $this->identityMap::get($id)) {
            return $user;
        }

        $result = $this->queryBuilder
            ->table('users')
            ->select(['id', 'name', 'surname'])
            ->from('users')
            ->where('id = ' . $user->getId())
            ->getQuery()
            ->getResult();

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
        $count = $this->queryBuilder->table('users')
            ->select(['id', 'name', 'surname'])
            ->from('users')
            ->getQuery()
            ->getCount();

        if ($count === $this->identityMap::count()) {
            return $this->identityMap::getAll();
        }

        $result = $this->queryBuilder->getResult();

        return CollectionFactory::fromIterable($result)
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
