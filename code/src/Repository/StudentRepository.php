<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    /**
     * @return Student[]
     */
    public function getStudents(int $page, int $perPage): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from($this->getClassName(), 't')
            ->orderBy('t.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $qb->getQuery()->getResult();
    }

    public function getStudentByUserLogin(string $login): Student
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('st')
            ->from($this->getClassName(), 'st')
            ->join('st.user', 'u')
            ->andWhere('u.login = :login');
        $qb->setParameter('login', $login);

        return $qb->getQuery()->getResult()[0];
    }


}