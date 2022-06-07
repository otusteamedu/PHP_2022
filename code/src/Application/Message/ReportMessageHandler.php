<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Application\Service\ReportDataService;
use App\Domain\Message\ReportMessage;
use App\Infrastructure\Repository\ReportRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[AsMessageHandler(priority: 10)]
class ReportMessageHandler implements MessageHandlerInterface
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function __invoke(ReportMessage $message): void
    {
        $getIdQueque = $message->getIdQueque();
        $this->reportRepository->create($getIdQueque, $message->getContent());

        try {
            sleep(10);

            $this->reportRepository->setStatus($getIdQueque,ReportDataService::STATUS_SUCCESS);
        } catch (\Throwable $e) {
            $this->reportRepository->setStatus($getIdQueque,ReportDataService::STATUS_FAILED);
        }
    }
}