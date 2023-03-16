<?php

namespace App\Repository;

use App\Entity\TaskSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class TaskSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskSkills::class);
    }

    /**
     * @return Skill[]
     */
    public function getSkills(int $page, int $perPage): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder->select('s')
            ->from(Skill::class, 's')
            ->orderBy('s.title', 'ASC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int[] $skill_ids
     * @return TaskSkills[]
     */
    public function getTaskBySkill(array $skill_ids) : array
    {
        $result = [];
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('s.title skill, t.title as task, ts.percent as percent')
            ->from($this->getClassName(), 'ts')
            ->join('ts.skill', 's')
            ->join('ts.task', 't')
            ->where('s.id in ( :skill_ids )')
            ->orderBy('skill, task');
        $qb->setParameter('skill_ids', $skill_ids );

        $result  =  $qb->getQuery()->getResult();
        return $result;
    }
}
