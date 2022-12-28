<?php

declare(strict_types=1);

namespace App\Infrastructure\Dao;

use App\Domain\Contract\AccountStatementDaoInterface;
use App\Domain\Entity\AccountStatement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class AccountStatementDao implements AccountStatementDaoInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function create(AccountStatement $accountStatement): Uuid
    {
        $this->entityManager->persist($accountStatement);
        $this->entityManager->flush();

        return $accountStatement->getId();
    }

    public function delete(AccountStatement $accountStatement): void
    {
        $this->entityManager->remove($accountStatement);
        $this->entityManager->flush();
    }

    public function update(AccountStatement $accountStatement): void
    {
        $this->entityManager->flush();
    }
}