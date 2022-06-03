<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Report;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);
    }

    public function setStatus(string $idQueque, int $status): bool
    {
        $entityManager = $this->getEntityManager();

        $result = $entityManager->createQuery("UPDATE App\Domain\Entity\Report o 
            SET o.status = :status
            WHERE o.idQueque = :idQueque")
            ->setParameter('status', $status)
            ->setParameter('idQueque', $idQueque)
            ->getResult();

        return (bool) $result;
    }
}