<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\ElasticSearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticSearchClient
{
    private Client $client;
    private const ELASTIC_SEARCH_HOST = ['elasticsearch:9200'];

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(self::ELASTIC_SEARCH_HOST)
            ->build();
    }


    public function search($params)
    {
        $result = $this->client->search($params);
        return array_map(fn($item) => $item['_source'], $result['hits']['hits']);
    }
}