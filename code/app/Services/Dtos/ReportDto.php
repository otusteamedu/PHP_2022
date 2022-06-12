<?php


namespace App\Services\Dtos;


use stdClass;

class ReportDto
{
    public function __construct(private stdClass $report, private array $params)
    {
    }

    public function getReport(): stdClass
    {
        return $this->report;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
