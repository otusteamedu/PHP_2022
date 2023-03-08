#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Infrastructure\Queue\Consumers\DnsRecordsConsumer;

try {
    app()->register(name: 'dns_records_http_client_gateway', value: function () {
        return new \Infrastructure\DnsRecords\DnsRecordHttpClient();
    });

    app()->register(name: 'get_host_dns_records', value: function () {
        return new \Domain\DnsRecords\UseCase\GetHostDnsRecords();
    });

    $consumer = new DnsRecordsConsumer();

    $consumer->consume();
} catch (Throwable $exception) {
    var_dump(value: 'Exception: ' . $exception->getMessage() . PHP_EOL . 'Trace:' . $exception->getTraceAsString());
}
