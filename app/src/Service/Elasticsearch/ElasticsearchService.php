<?php

namespace App\Service\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchService
{
    private Client $client;

    public function __construct(string $hosts)
    {
        $hosts = explode('|', $hosts);
        $this->client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}