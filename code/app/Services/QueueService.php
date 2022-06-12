<?php


namespace App\Services;


use App\Services\Interfaces\ConsumerQueueInterface;
use App\Services\Interfaces\PublisherQueueInterface;
use App\Services\Dtos\ReportDto;
use App\Services\Interfaces\ReportExecuteHandlerInterface;

final class QueueService
{
    public const STATUS_READY = 'ready';
    public const STATUS_PROCESS = 'in_queue';
    public const STATUS_DONE = 'success';
    public const STATUS_ERROR = 'error';

    public function __construct(
        private PublisherQueueInterface $publisher,
        private ConsumerQueueInterface $consumer,
    ) {
    }

    public function publish(ReportDto $reportDto): void
    {
        $this->publisher->handle($reportDto);
    }

    public function consume(ReportExecuteHandlerInterface $handler):void
    {
        $this->consumer->handle($handler);
    }
}
