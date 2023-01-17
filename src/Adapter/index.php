<?php

namespace Patterns\Adapter;

use Exception;

require __DIR__ . '/../../vendor/autoload.php';

$reports = [
    new ArrayReport(),
    new JsonReport(),
    new XMLReport(),
];

/**
 * @throws Exception
 */
function clientCode(array $reports): void
{
    $reportData = '';

    foreach ($reports as $report) switch ($report) {
        case $report instanceof ArrayReport:
            $reportData = $report;
            break;
        case $report instanceof JsonReport:
            $reportData = new JsonReportAdapter($report);
            break;
        case $report instanceof XMLReport:
            $reportData = new XMLReportAdapter($report);
            break;
        default:
            throw new Exception('Unexpected value');
    }

    renderView($reportData);
}

function renderView(ReportAdapterInterface $adapter)
{
    print_r($adapter->getData());
}

try {
    clientCode($reports);
} catch (Exception $e) {
}
