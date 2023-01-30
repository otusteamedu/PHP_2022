<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Infrastructure\Storage;

use Dkozlov\Otus\Application;
use Dkozlov\Otus\Application\Dto\SearchResponse;
use Dkozlov\Otus\Application\QueryBuilder\SearchQueryBuilder;
use Dkozlov\Otus\Application\Storage\StorageException;
use Dkozlov\Otus\Application\Storage\StorageInterface;
use Dkozlov\Otus\Exception\FileNotFoundException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElasticSearchStorage implements StorageInterface
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

    public function loadJSON(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File by path \"{$path}\" not found");
        }

        $body = file_get_contents($path);

        try {
            $this->client->bulk(['body' => $body]);
        } catch (ClientResponseException|ServerResponseException $exception) {
            throw new StorageException($exception->getMessage());
        }
    }

    public function search(SearchQueryBuilder $queryBuilder): SearchResponse
    {
        $params = [
            'index' => Application::config('elastic_index'),
            'body' => [
                'query' => $queryBuilder->getParams()
            ]
        ];

        try {
            $response = $this->client->search($params)->asArray();

            return new SearchResponse(array_column($response['hits']['hits'], '_source'));
        } catch (ClientResponseException|ServerResponseException $exception) {
            throw new StorageException($exception->getMessage());
        }
    }

}