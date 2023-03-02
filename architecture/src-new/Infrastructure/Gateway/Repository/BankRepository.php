<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway\Repository;

use App\Application\Gateway\Repository\BankRepositoryInterface;
use App\Domain\Entity\Bank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Dvizh\DoctrineBundle\Repository\FindOrFailInterface;
use Dvizh\DoctrineBundle\Repository\FindOrFailTrait;

/**
 * @extends ServiceEntityRepository<Bank>
 */
class BankRepository extends ServiceEntityRepository implements FindOrFailInterface, BankRepositoryInterface
{
    use FindOrFailTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bank::class);
    }
}
