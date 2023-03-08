<?php

declare(strict_types=1);

app()->register(name: 'api_task_repository', value: function () {
    return new \Models\ApiTasks();
});

app()->register(name: 'queue_publisher', value: function () {
    return new \Infrastructure\Queue\Publisher();
});

app()->post(
    pattern: '/api/v1/dns-records/{host}',
    handler: 'DnsRecords\DnsRecordsController@get'
);
