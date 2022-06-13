<?php


namespace App\Services;


use App\Services\QueueInterfaces\ConsumerQueueInterface;
use App\Services\QueueInterfaces\PublisherQueueInterface;
use App\Services\Dtos\ReportDto;

final class QueueService
{
    public function __construct(
        private PublisherQueueInterface $publisher,
        private ConsumerQueueInterface $consumer,
    ) {
    }

    public function publish(ReportDto $reportDto): void
    {
        $this->publisher->handle($reportDto);
    }

    public function consume():void
    {
        $this->consumer->handle();
    }
}
