<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Application\Service\ReportDataService;
use App\Domain\Message\ReportMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(priority: 10)]
class ReportMessageHandler
{
    private ReportDataService $reportDataService;

    public function __construct(ReportDataService $reportDataService)
    {
        $this->reportDataService = $reportDataService;
    }

    public function __invoke(ReportMessage $message): void
    {
        $getIdQueque = $message->getIdQueque();

        $this->reportDataService->create();

        try {
            sleep(10);

            $this->reportDataService->update($getIdQueque, ReportDataService::STATUS_SUCCESS);
        } catch (\Throwable $e) {
            $this->reportDataService->update($getIdQueque, ReportDataService::STATUS_FAILED);
        }
    }

    public static function getHandledMessages(): iterable
    {
        yield ReportMessage::class;
    }
}