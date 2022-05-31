<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\Domain\Entity\Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public const STATUS_PAID = 2;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function setOrderIsPaid(string $orderNumber, float $sum): bool
    {
        $entityManager = $this->getEntityManager();

        $result = $entityManager->createQuery("UPDATE App\Domain\Entity\Order o 
            SET o.status = :status
            WHERE o.number = :number
            AND o.sum = :sum")
        ->setParameter('number', $orderNumber)
        ->setParameter('sum', $sum)
        ->setParameter('status', static::STATUS_PAID)
        ->getResult();

        return (bool) $result;
    }
}
