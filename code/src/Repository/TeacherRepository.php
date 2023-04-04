<?php

namespace App\Repository;

use App\Entity\Teacher;
use Doctrine\ORM\EntityRepository;

class TeacherRepository extends EntityRepository
{
    /**
     * @return Teacher[]
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


}