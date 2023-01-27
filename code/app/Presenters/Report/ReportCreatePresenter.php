<?php


namespace App\Presenters\Report;


use App\Presenters\AbstractPresenter;
use App\Services\Dtos\ReportDto;

final class ReportCreatePresenter extends AbstractPresenter
{
    public function __construct(private ReportDto $report)
    {
    }

    public function getResult(): array
    {
        return [
            'status' => $this->report->getReport()->status,
            'reportId' => $this->report->getReport()->id,
            'params' => $this->report->getParams(),
        ];
    }
}
