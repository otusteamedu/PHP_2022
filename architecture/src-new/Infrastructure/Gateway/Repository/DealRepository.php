<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Repository;

use App\Application\Gateway\Repository\DealRepositoryInterface;
use App\Domain\Entity\Bank;
use App\Domain\Entity\Deal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dvizh\DoctrineBundle\Repository\FindOrFailInterface;
use Dvizh\DoctrineBundle\Repository\FindOrFailTrait;

/**
 * @extends ServiceEntityRepository<Deal>
 */
class DealRepository extends ServiceEntityRepository implements FindOrFailInterface, DealRepositoryInterface
{
    use FindOrFailTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deal::class);
    }
}
