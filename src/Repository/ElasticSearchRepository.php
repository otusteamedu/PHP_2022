<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository;

use Dkozlov\Otus\Application;
use Dkozlov\Otus\Exception\EmptySearchQueryException;
use Dkozlov\Otus\Exception\FileNotFoundException;
use Dkozlov\Otus\Exception\RepositoryException;
use Dkozlov\Otus\QueryBuilder\SearchQueryBuilder;
use Dkozlov\Otus\Repository\Interface\RepositoryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearchRepository implements RepositoryInterface
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

    public function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File by path \"{$path}\" not found");
        }

        $books = file_get_contents($path);

        try {
            $this->client->bulk(['body' => $books]);
        } catch (ClientResponseException|ServerResponseException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function search(SearchQueryBuilder $queryBuilder): array
    {
        $query = $queryBuilder->getParams();

        if (empty($query)) {
            throw new EmptySearchQueryException('Search params are not set');
        }

        $params = [
            'index' => Application::config('elastic_index'),
            'body' => [
                'query' => $query
            ]
        ];

        try {
            $response = $this->client->search($params);

            return $response->asArray()['hits']['hits'] ?? [];
        } catch (ClientResponseException|ServerResponseException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
}