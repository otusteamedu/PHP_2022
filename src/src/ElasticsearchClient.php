<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticsearchClient
{
    private const HOSTS = ['elasticsearch:9200'];
    private const INDEX = "otus-shop";
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(self::HOSTS)
            ->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $body): array
    {
        $response = $this->client->search(
            [
            'index' => self::INDEX,
            'body' => $body
            ]
        );

        return array_map(fn($item) => $item['_source'], $response['hits']['hits']);
    }
}
