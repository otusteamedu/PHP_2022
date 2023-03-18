<?php

namespace Svatel\Code\Commands;

use Elastic\Elasticsearch\Client;

class SearchCommand
{
    public function __construct(private Client $client, private ?string $query = null)
    {
    }

    public function search(): array
    {
        if (!is_null($this->query)) {
            $params = json_decode($this->query, true);
        } else {
            $params = json_decode(file_get_contents('/app/query/search.json'), true);
        }

        try {
            $response = $this->client->search($params);
            return $response['hits']['hits'];
        } catch (\Exception $e) {
            print_r('Произошла ошибка при поиске');
        }
    }
}
