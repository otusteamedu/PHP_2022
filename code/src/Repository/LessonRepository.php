<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    /**
     * @return Lesson[]
     */
    public function getLessonsSortByTitle(int $page, int $perPage, int $courseId): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('l')
            ->from($this->getClassName(), 'l');
        if(!is_null($courseId)){
            $queryBuilder->where('l.course = :courseId');
        }
        $queryBuilder
            ->orderBy('l.title', 'ASC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);
        if(!is_null($courseId)){
            $queryBuilder->setParameter(':courseId', $courseId);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function getLessonsSortByOrder(int $page, int $perPage): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('l')
            ->from($this->getClassName(), 'l')
            ->orderBy('l.title', 'ASC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }
}
