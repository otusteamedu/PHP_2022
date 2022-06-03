<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Report;
use App\Domain\Entity\Status;
use App\Domain\Message\ReportMessage;
use App\Infrastructure\Requests\ReportDataRequest;
use App\Infrastructure\Response\ResponseSuccess;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * ReportDataService
 */
class ReportDataService
{
    public const STATUS_START = 1;
    public const STATUS_SUCCESS = 2;
    public const STATUS_FAILED = 3;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;
    private ReportDataRequest $reportDataRequest;
    private MessageBusInterface $messageBus;
    private string $generateIdQueque;

    public function __construct(EntityManagerInterface $entityManager, ReportDataRequest $reportDataRequest, MessageBusInterface $messageBus)
    {
        $this->em = $entityManager;
        $this->reportDataRequest = $reportDataRequest;
        $this->messageBus = $messageBus;
        $this->generateIdQueque = $this->generateIdQueque();
    }

    public function index(): JsonResponse
    {
        $this->reportDataRequest->validate();

        $this->messageBus->dispatch(new ReportMessage($this->reportDataRequest->getMessage(), $this->generateIdQueque));

        return (new ResponseSuccess())->send();
    }

    public function create(): void
    {
        $status =  $this->em->getRepository(Status::class)->find(static::STATUS_START);
        $report = new Report();
        $report->setStatus($status);
        $report->setName($this->reportDataRequest->getMessage());
        $report->setIdQueque($this->generateIdQueque);
        $this->em->persist($report);
        $this->em->flush();
    }

    public function update(string $idQueque, int $status): bool
    {
       $this->em->getRepository(Report::class)->setStatus($idQueque, $status);

       return true;
    }

    public function getStatus(string $idQueque): Report
    {
        return $this->em->getRepository(Report::class)->findOneBy(['idQueque' => $idQueque]);
    }

    private function generateIdQueque(): string
    {
        return md5('1234567890'.time());
    }
}