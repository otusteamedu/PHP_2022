<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Report;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ReportDataService
 */
class ReportDataCommandService
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getStatus(string $idQueque): Report
    {
        return $this->em->getRepository(Report::class)->findOneBy(['idQueque' => $idQueque]);
    }
}
