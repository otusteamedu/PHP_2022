<?php

namespace App\Presenters\Report;

use App\Presenters\AbstractPresenter;
use JsonException;
use stdClass;

final class ReportViewPresenter extends AbstractPresenter
{
    public function __construct(private stdClass $report)
    {
    }

    /**
     * @throws JsonException
     */
    public function getResult(): array
    {
        return [
            'reportId' => $this->report->id,
            'result' => $this->report->compiled_data,
            'status' => $this->report->status,
            'params' => json_decode($this->report->params, true, 512, JSON_THROW_ON_ERROR),
            'created_at' => $this->report->created_at,
            'updated_at' => $this->report->updated_at,
        ];
    }
}
