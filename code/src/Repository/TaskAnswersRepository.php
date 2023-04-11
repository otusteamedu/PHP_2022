<?php

namespace App\Repository;

use App\Entity\TaskAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TaskAnswersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskAnswers::class);
    }


    public function getCorrectAnswersIdsByTask(int $taskId)
    {
        $result = [];
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('ta.id')
            ->from($this->getClassName(), 'ta')
            ->where('ta.task = :taskId and ta.isCorrect = true')
            ->orderBy('ta.id');
        $qb->setParameter(':taskId', $taskId );

        $result  =  $qb->getQuery()->getScalarResult();

       return $result;
    }


}
