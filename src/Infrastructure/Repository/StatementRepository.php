<?php

namespace App\Infrastructure\Repository;

use App\Application\Contract\StatementRepositoryInterface;
use App\Domain\Entity\Statement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\Domain\Entity\Statement>
 *
 * @method Statement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statement[]    findAll()
 * @method Statement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatementRepository extends ServiceEntityRepository implements StatementRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statement::class);
    }

    public function add(Statement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Statement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneById(string $value): ?Statement
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
