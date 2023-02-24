<?php

namespace App\Provider\Elastic\Command\Index;

use Elastic\Elasticsearch\Client;
use Exception;

class GetIndexCommand
{
    /**
     * @param string $index
     * @param Client $client
     * @throws Exception
     */
    public function __construct(private string $index, private Client $client)
    {
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
        ];
    }
}