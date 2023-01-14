<?php

include __DIR__ . '/vendor/autoload.php';

use Onbalt\ServicedeskplusApi\ServicedeskplusApi;

$config = [
    'api_base_url' => 'http://helpdesk.local/api/v3/',
    'technician_key' => 'YOUR_TECHNICIAN_KEY',
    'api_version' => '3',
    'api_v1_format' => 'json',
    'timeout' => 60,
];

$sdpApi = new ServicedeskplusApi($config);
$testData = $sdpApi->prepareJsonInputData([1=>2, 3=>4]);
var_dump($testData);

// View Request
$response = $sdpApi->get('requests/111');
var_dump($response->request);