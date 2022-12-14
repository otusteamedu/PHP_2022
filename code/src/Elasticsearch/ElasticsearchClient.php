<?php

namespace Study\Cinema\Elasticsearch;

use Elastic\Elasticsearch\Client;

class ElasticsearchClient
{
    private $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function search($params)
    {
        return $this->client->search($params);
    }
}