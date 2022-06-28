<?php


namespace App\Presenters\Report;


use App\Presenters\AbstractPresenter;
use stdClass;

final class ReportStatusPresenter extends AbstractPresenter
{
    public function __construct(private stdClass $report)
    {
    }

    public function getResult(): array
    {
        return [
            'reportId' => $this->report->id,
            'status' => $this->report->status,
            'created_at' => $this->report->created_at,
        ];
    }
}
