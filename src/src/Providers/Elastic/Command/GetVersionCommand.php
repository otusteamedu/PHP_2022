<?php

namespace App\Providers\Elastic\Command;

use Elastic\Elasticsearch\Client;

class GetVersionCommand
{
    public function __construct(private Client $client)
    {
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}