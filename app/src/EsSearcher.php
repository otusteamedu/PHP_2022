<?php

namespace app;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;

class EsSearcher {
    private Client $client;
    private string $index;
    private array $query;

    public function __construct(string $index, $query = []) {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->setBasicAuthentication($_ENV['ELASTIC_USERNAME'], $_ENV['ELASTIC_PASSWORD'])
            ->setCABundle(__DIR__.'/../../http_ca.crt')
            ->build();
        $this->index = $index;
        $this->query = $query;
    }

    public function stats() {
        return $this->client->count(['index' => $this->index])->asArray();
    }

    public function search() {
        $params = [
            'index' => $this->index,
            'body' => [
                "sort" => ["_score"],
                'query' => $this->query
            ]
        ];

        return $this->client->search($params)->asArray();
    }
}
