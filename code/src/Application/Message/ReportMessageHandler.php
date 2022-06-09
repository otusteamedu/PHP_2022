<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Application\Service\ReportDataService;
use App\Domain\Message\ReportMessage;
use App\Infrastructure\Repository\ReportRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * ReportMessageHandler
 */
#[AsMessageHandler(priority: 10)]
class ReportMessageHandler implements MessageHandlerInterface
{
    /**
     * @var ReportRepository
     */
    private ReportRepository $reportRepository;

    /**
     * @param ReportRepository $reportRepository
     */
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * @param ReportMessage $message
     * @return void
     */
    public function __invoke(ReportMessage $message): void
    {
        if ($message->getType() == 'delete') {
            $this->reportRepository->remove($message->getIdQueque());
        } else {
            $this->extracted($message);
        }
    }

    /**
     * @param ReportMessage $message
     * @return void
     */
    public function extracted(ReportMessage $message): void
    {
        try {

            if ($message->getType() == 'create') {
                $this->reportRepository->create($message);
            } else {
                $this->reportRepository->setStatus($message, ReportDataService::STATUS_START);
            }

            sleep(10);

            $this->reportRepository->setStatus($message, ReportDataService::STATUS_SUCCESS);
        } catch (\Throwable $e) {
            $this->reportRepository->setStatus($message, ReportDataService::STATUS_FAILED);
        }
    }
}