<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Bank;
use App\Entity\Deal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dvizh\DoctrineBundle\Repository\FindOrFailInterface;
use Dvizh\DoctrineBundle\Repository\FindOrFailTrait;

/**
 * @extends ServiceEntityRepository<Deal>
 */
class DealRepository extends ServiceEntityRepository implements FindOrFailInterface
{
    use FindOrFailTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deal::class);
    }

    /**
     * @return Deal[]
     */
    public function findDealsForCheckState(): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT d
            FROM App\Entity\Deal d
            WHERE d.nextCheckStatusDate IS NOT NULL
                AND d.nextCheckStatusDate < :datetime
                AND d.external_id IS NOT NULL'
        )
            ->setParameter('datetime', new \DateTimeImmutable())
        ;

        /** @var Deal[] $deals */
        $deals = $query->getResult();

        return $deals;
    }

    public function findByExternalIdAndBank(string $externalId, Bank $bank): ?Deal
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT d
            FROM App\Entity\Deal d
            WHERE d.external_id = :externalId AND d.bank = :bank'
        )
            ->setParameter('externalId', $externalId)
            ->setParameter('bank', $bank)
        ;

        /** @var Deal|null $deal */
        $deal = $query->getOneOrNullResult();

        return $deal;
    }
}
