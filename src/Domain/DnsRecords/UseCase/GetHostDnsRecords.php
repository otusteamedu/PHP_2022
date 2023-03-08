<?php

declare(strict_types=1);

namespace Domain\DnsRecords\UseCase;

use Domain\Contracts\Infrastructure\DnsRecords\DnsRecordsHttpClientGateway;

final class GetHostDnsRecords
{
    /**
     * @var DnsRecordsHttpClientGateway|mixed
     */
    private DnsRecordsHttpClientGateway $dns_records_http_client_gateway;

    public function __construct()
    {
        $this->dns_records_http_client_gateway = app()->dns_records_http_client_gateway;
    }

    /**
     * @param string $host
     * @return string
     */
    public function get(string $host): string
    {
        return $this->dns_records_http_client_gateway->getAAAArecords(host: $host);
    }
}
