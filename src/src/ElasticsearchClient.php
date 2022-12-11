<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticsearchClient
{
    private const HOSTS = ['elasticsearch:9200'];
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
}