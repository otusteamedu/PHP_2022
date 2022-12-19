<?php


namespace Study\Cinema\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Study\Cinema\Elasticsearch\ElasticsearchClient;

class ElasticsearchClientBuilder
{

    public static function create()
    {
        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();

        return new ElasticSearchClient($client);
    }

}