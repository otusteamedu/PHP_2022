<?php

namespace App\Repository;

use App\Entity\JsonEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JsonEvent>
 *
 * @method JsonEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method JsonEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method JsonEvent[]    findAll()
 * @method JsonEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JsonEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JsonEvent::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(JsonEvent $entity, bool $flush = false): void
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
    public function remove(JsonEvent $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
