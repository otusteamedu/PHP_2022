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
    public function search(array $criteria = [])
    {
        $condition = [
            'filter' => [],
            'must' => []
        ];

        if (isset($criteria['priceGt'])) {
            $condition['filter'][] = ['range' => ['price' => ['gte' => $criteria['priceGt']]]];
        }

        if (isset($criteria['priceLt'])) {
            $condition['filter'][] = ['range' => ['price' => ['lte' => $criteria['priceLt']]]];
        }

        if (isset($criteria['in-stock'])) {
            $condition['filter'][] = ['range' => ['stock.stock' => ['gt' => 0]]];
        }

        if (isset($criteria['sku'])) {
            $condition['filter'][] = ['term' => ['sku' => $criteria['sku']]];
        }

        if (isset($criteria['shop'])) {
            $condition['filter'][] = ['term' => ['shop' => $criteria['shop']]];
        }

        if (isset($criteria['title'])) {
            $condition['must'][] = ['match' => ['title' => $criteria['title']]];
        }

        if (isset($criteria['category'])) {
            $condition['must'][] = ['match' => ['category' => $criteria['category']]];
        }

        $params = [
            'index' => $_ENV['ES_INDEX'],
            'body' => [
                'query' => [
                    'bool' => $condition
                ]
            ]
        ];

        return $this->client->search($params)->asArray();
    }
}
