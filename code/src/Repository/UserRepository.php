<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from($this->getClassName(), 't')
            ->orderBy('t.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $qb->getQuery()->getResult();
    }
    public function getUsersByRole(string $role, int $page, int $perPage): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
            ->from($this->getClassName(), 'u')
            ->andWhere($qb->expr()->like('u.roles', $qb->expr()->literal('%' . $role . '%')))
            ->orderBy('u.login', 'ASC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

       // print ($qb->getQuery()->getSQL());
        return $qb->getQuery()->getResult();
    }
}