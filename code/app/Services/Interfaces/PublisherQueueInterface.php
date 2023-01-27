<?php


namespace App\Services\Interfaces;


use App\Services\Dtos\ReportDto;

interface PublisherQueueInterface
{
    public function handle(ReportDto $dto): void;
}
