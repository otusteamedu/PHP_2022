<?php

namespace Patterns\Adapter;

class JsonReportAdapter implements ReportAdapterInterface
{
    private JsonReport $jsonReport;

    public function __construct(JsonReport $jsonReport)
    {
        $this->jsonReport = $jsonReport;
    }

    public function getData(): array
    {
        $data = $this->jsonReport->buildJson();
        return json_decode($data, true);
    }
}
