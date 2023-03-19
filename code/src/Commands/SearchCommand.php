<?php

namespace Svatel\Code\Commands;

use Elastic\Elasticsearch\Client;

class SearchCommand
{
    public function __construct(private Client $client, private string $query)
    {
    }

    public function search(): array
    {
        if (!file_exists($this->query)) {
            $params = json_decode($this->query, true);
        } else {
            $params = json_decode(file_get_contents($this->query), true);
        }

        try {
            $response = $this->client->search($params);
            return $response['hits']['hits'];
        } catch (\Exception $e) {
            print_r('Произошла ошибка при поиске');
        }
    }
}
