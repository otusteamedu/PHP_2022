<?php

namespace Patterns\Adapter;

class XMLReportAdapter implements ReportAdapterInterface
{
    private XMLReport $xmlReport;

    public function __construct(XMLReport $xmlReport)
    {
        $this->xmlReport = $xmlReport;
    }

    public function getData(): array
    {
        $xmlData = $this->xmlReport->buildXML();
        $xml = simplexml_load_string($xmlData);
        return json_decode(json_encode($xml), true)['row'];
    }
}
