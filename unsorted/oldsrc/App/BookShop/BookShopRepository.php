<?php

declare(strict_types=1);

namespace App\App\BookShop;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class BookShopRepository
{
    private const INDEX_NAME = 'otus-shop';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $query)
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body'  => [
                'query' => $query,
            ],
        ];

        return $this->client->search($params);
    }
}