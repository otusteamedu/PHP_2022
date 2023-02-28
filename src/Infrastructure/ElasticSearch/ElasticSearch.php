<?php

namespace App\Infrastructure\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearch
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elastic_search:9200'])
            ->build();
    }

    public function index(array $data): void
    {
        $this->client->index($data);
    }

    public function search(array $params = []): \Elastic\Elasticsearch\Response\Elasticsearch
    {
        return $this->client->search($params);
    }

}
