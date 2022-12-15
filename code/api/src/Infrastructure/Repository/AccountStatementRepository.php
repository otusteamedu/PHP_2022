<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Contract\AccountStatementRepositoryInterface;
use App\Domain\Entity\AccountStatement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class AccountStatementRepository extends ServiceEntityRepository implements AccountStatementRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountStatement::class);
    }

    public function findById(Uuid $id): ?AccountStatement
    {
        return parent::find($id);
    }

    public function findAll(): iterable
    {
        return parent::findAll();
    }
}