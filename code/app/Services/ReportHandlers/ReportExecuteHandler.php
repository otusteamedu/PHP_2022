<?php

namespace App\Services\ReportHandlers;

use App\Services\Interfaces\ReportExecuteHandlerInterface;
use App\Services\ReportService;
use JsonException;

class ReportExecuteHandler implements ReportExecuteHandlerInterface
{
    public function __construct(private ReportService $service)
    {
    }

    /**
     * @throws JsonException
     */
    public function process(int $id): void
    {
        $this->service->process($id);
    }

    public function setStatusQueue(int $id, string $status): void
    {
        $this->service->setInQueue($id, $status);
    }
}
