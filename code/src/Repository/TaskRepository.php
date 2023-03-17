<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;




class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function getTasksSortByTitle(int $page, int $perPage, int $lessonId): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('t')
            ->from($this->getClassName(), 't');
        if(!is_null($lessonId)){
            $queryBuilder->where('t.lesson = :lessonId');
        }
        $queryBuilder
            ->orderBy('t.id', 'ASC')
            ->setFirstResult($page * $perPage )
            ->setMaxResults($perPage);
        if(!is_null($lessonId)){
            $queryBuilder->setParameter(':lessonId', $lessonId);
        }

        return $queryBuilder->getQuery()->enableResultCache(null,"tasks_all_{$page}_{$perPage}" )->getResult();
    }
    /**
     * @return Task[]
     */
    public function getAllTasksByLesson(int $lessonId):array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select(' t ')
            ->from($this->getClassName(), 't')
            ->where('t.lesson = :lessonId');
            //->setFirstResult($page * $perPage )
            //->setMaxResults($perPage);

        $qb->setParameter('lessonId', $lessonId);

        return $qb->getQuery()->getResult();
    }
}
