<?php

namespace App\Services\Dtos;

class ReportDto
{
    public function __construct(private int $reportId, private array $params)
    {
    }

    public function getReportId(): int
    {
        return $this->reportId;
    }
    public function getParams(): array
    {
        return $this->params;
    }
}
