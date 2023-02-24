<?php

namespace App\Providers\Elastic\Command\Search;

use Elastic\Elasticsearch\Client;
use Exception;

class SearchCommand
{
    /**
     * @param string $field
     * @param string $query
     * @param string $index
     * @param Client $client
     * @throws Exception
     */
    public function __construct(
        private string $field,
        private string $query,
        private string $index,
        private Client $client
    )
    {
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function buildParams(): array
    {
        return [
            'index' => $this->getIndex(),
            'body' => [
                'query' => [
                    'match' => [
                        $this->getField() => $this->getQuery()
                    ]
                ]
            ]
        ];
    }
}