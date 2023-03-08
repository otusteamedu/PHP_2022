<?php

declare(strict_types=1);

namespace Infrastructure\DnsRecords;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Domain\Contracts\Infrastructure\DnsRecords\DnsRecordsHttpClientGateway;

final class DnsRecordHttpClient implements DnsRecordsHttpClientGateway
{
    /**
     * @var Client
     */
    private Client $http_client;

    public function __construct()
    {
        $this->http_client = new Client();
    }

    /**
     * @param string $host
     * @return string
     * @throws GuzzleException
     */
    public function getAAAArecords(string $host): string
    {
        $response = $this->http_client->request(
            method: 'GET',
            uri: 'https://dns.google/resolve?name=' . $host . '&type=AAAA'
        );

        return $response->getBody()->getContents();
    }
}
