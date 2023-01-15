<?php

namespace Otus\Task11\Core\ElasticSearch;


use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticManager
{
    private Client $client;

    public function __construct(array $config){

        $this->client = ClientBuilder::create()
            ->setHosts($config['hosts'])
            ->build();
    }

    public function getClient(): Client{
        return $this->client;
    }


}