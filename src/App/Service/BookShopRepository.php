<?php

declare(strict_types=1);

namespace App\App\Service;

use Elastic\Elasticsearch\ClientInterface;

class BookShopRepository
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function search()
    {
        return $this->client->info();
    }
}