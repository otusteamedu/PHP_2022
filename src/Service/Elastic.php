<?php

declare(strict_types=1);

namespace Pinguk\ElasticApp\Service;

use Elastic\Elasticsearch\{Client, ClientBuilder, Exception\AuthenticationException, Exception\ClientResponseException, Exception\ServerResponseException};

class Elastic
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ES_HOST']])
            ->setBasicAuthentication($_ENV['ES_LOGIN'], $_ENV['ES_PASSWORD'])
            ->setCABundle($_ENV['ES_CERT_PATH'])
            ->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $query = []): array
    {
        $params = [
            'index' => $_ENV['ES_INDEX'],
            'body' => [
                'query' => $query
            ]
        ];

        return $this->client->search($params)->asArray();
    }
}
