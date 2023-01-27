<?php

namespace App\Presenters\Report;

use App\Presenters\AbstractPresenter;
use App\Services\Dtos\ReportDto;

final class ReportCreatePresenter extends AbstractPresenter
{
    /**
     * @param ReportDto $report
     */
    public function __construct(private ReportDto $report)
    {
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return [
            'status' => $this->report->getReport()->status,
            'reportId' => $this->report->getReport()->id,
            'params' => $this->report->getParams(),
        ];
    }
}
