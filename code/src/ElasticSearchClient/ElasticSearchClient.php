<?php

declare(strict_types=1);

namespace Nikolai\Php\ElasticSearchClient;

use Elasticsearch\Client;
use Elasticsearch\Namespaces\IndicesNamespace;

class ElasticSearchClient implements ElasticSearchClientInterface
{
    public function __construct(private Client $client) {}

    public function get(array $params = []): array
    {
        return $this->client->get($params);
    }

    public function create(array $params = []): array
    {
        return $this->client->create($params);
    }

    public function bulk(array $params = []): array
    {
        return $this->client->bulk($params);
    }

    public function delete(array $params = []): array
    {
        return $this->client->delete($params);
    }

    public function index(array $params = []): array
    {
        return $this->client->index($params);
    }

    public function info(array $params = []): array
    {
        return $this->client->info($params);
    }

    public function reindex(array $params = []): array
    {
        return $this->client->reindex($params);
    }

    public function search(array $params = []): array
    {
        return $this->client->search($params);
    }

    public function update(array $params = []): array
    {
        return $this->client->update($params);
    }

    public function indices(): IndicesNamespace
    {
        return $this->client->indices();
    }
}