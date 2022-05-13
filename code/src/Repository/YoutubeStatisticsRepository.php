<?php

namespace App\Repository;

use App\Entity\YoutubeStatistics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<YoutubeStatistics>
 *
 * @method YoutubeStatistics|null find($id, $lockMode = null, $lockVersion = null)
 * @method YoutubeStatistics|null findOneBy(array $criteria, array $orderBy = null)
 * @method YoutubeStatistics[]    findAll()
 * @method YoutubeStatistics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YoutubeStatisticsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YoutubeStatistics::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(YoutubeStatistics $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(YoutubeStatistics $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
