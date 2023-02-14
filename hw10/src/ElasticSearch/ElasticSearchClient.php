<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\ElasticSearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();
    }


    public function search($params)
    {
        $result = $this->client->search($params);
        return array_map(fn($item) => $item['_source'], $result['hits']['hits']);
    }
}