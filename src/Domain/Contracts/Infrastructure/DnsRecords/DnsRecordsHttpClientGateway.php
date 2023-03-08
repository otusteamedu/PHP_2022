<?php

declare(strict_types=1);

namespace Domain\Contracts\Infrastructure\DnsRecords;

interface DnsRecordsHttpClientGateway
{
    public function getAAAArecords(string $host): string;
}
