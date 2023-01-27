<?php

namespace App\Services\Dtos;

use stdClass;

class ReportDto
{
    /**
     * @param stdClass $report
     * @param array $params
     */
    public function __construct(private stdClass $report, private array $params)
    {
    }

    /**
     * @return stdClass
     */
    public function getReport(): stdClass
    {
        return $this->report;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
