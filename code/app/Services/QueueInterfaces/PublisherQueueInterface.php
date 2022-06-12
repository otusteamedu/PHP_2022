<?php


namespace App\Services\QueueInterfaces;


use App\Services\Dtos\ReportDto;

interface PublisherQueueInterface
{
    public function handle(ReportDto $dto): void;
}
