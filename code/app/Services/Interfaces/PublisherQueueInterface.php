<?php

namespace App\Services\Interfaces;

use App\Services\Dtos\ReportDto;

interface PublisherQueueInterface
{
    /**
     * @param ReportDto $dto
     * @return void
     */
    public function handle(ReportDto $dto): void;
}
