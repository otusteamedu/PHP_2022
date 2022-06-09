<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Service\ReportDataService;
use App\Domain\Entity\Report;
use App\Domain\Entity\Status;
use App\Domain\Message\ReportMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReportRepository extends ServiceEntityRepository
{
    private \Doctrine\ORM\EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Report::class);

        $this->em = $this->getEntityManager();
    }

    public function create(ReportMessage $message): void
    {
        $status = $this->em->getRepository(Status::class)->find(ReportDataService::STATUS_START);
        $report = new Report();
        $report->setStatus($status);
        $report->setName($message->getName());
        $report->setIdQueque($message->getIdQueque());
        $report->setUrl($message->getUrl());
        $this->em->persist($report);
        $this->em->flush();
    }

    public function setStatus(ReportMessage $message, int $status): bool
    {
        $result = $this->em->createQuery("UPDATE App\Domain\Entity\Report o 
            SET o.status = :status, o.url = :url 
            WHERE o.idQueque = :idQueque")
            ->setParameter('status', $status)
            ->setParameter('url', $message->getUrl())
            ->setParameter('idQueque', $message->getIdQueque())
            ->getResult();

        return (bool) $result;
    }

    public function getStatus(string $idQueque): Report
    {
        return $this->em->findOneBy(['idQueque' => $idQueque]);
    }

    public function remove(string $idQueque): void
    {
        $entity = $this->em->getRepository(Report::class)->findOneBy(['idQueque' => $idQueque]);
        $this->em->remove($entity);
        $this->em->flush();
    }
}

