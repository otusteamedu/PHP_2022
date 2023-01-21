<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository;

use Dkozlov\Otus\Application;
use Dkozlov\Otus\Exception\EmptySearchQueryException;
use Dkozlov\Otus\Exception\FileNotFoundException;
use Dkozlov\Otus\QueryBuilder\SearchBookQueryBuilder;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class BookRepository
{
    private readonly Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([Application::config('elastic_host')])
            ->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws FileNotFoundException
     */
    public function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File by path \"{$path}\" not found");
        }

        $books = file_get_contents($path);

        $this->client->bulk(['body' => $books]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws EmptySearchQueryException
     */
    public function search(SearchBookQueryBuilder $bookQuery): array
    {
        $query = $bookQuery->getParams();

        if (empty($query)) {
            throw new EmptySearchQueryException('Search params are not set');
        }

        $params = [
            'index' => Application::config('elastic_index'),
            'body' => [
                'query' => $query
            ]
        ];

        $response = $this->client->search($params);

        return $response->asArray()['hits']['hits'] ?? [];
    }
}