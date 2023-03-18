<?php

namespace Svatel\Code\Commands;

use Elastic\Elasticsearch\Client;

class IndexCommand
{
    public function __construct(private Client $client)
    {
    }
    public function create(): bool
    {
        try {
            $params['index'] = 'otus-shop';
            $params['body'] = json_decode(file_get_contents('/app/query/mapping.json'), true);
            $this->client->indices()->delete(['index' => 'otus-shop']);
            $this->client->indices()->create($params);

            $file = fopen('/app/query/books.json', 'r');
            $count = 0;
            $params = ['body' => []];
            while (!feof($file)) {
                $count = $count + 1;
                $line = fgets($file);
                $res = json_decode($line, true);
                if (isset($res['create'])) {
                    $params['body'][] = [
                        'index' => [
                            '_index' => $res['create']['_index'],
                            '_id' => $res['create']['_id']
                        ]
                    ];
                } else {
                    $params['body'][] = [
                        'title' => isset($res['title']) ?? '',
                        'sku' => isset($res['sku']) ?? '',
                        'category' => isset($res['category']) ?? '',
                        'price' => isset($res['price']) ?? '',
                        'stock' => isset($res['stock']) ?? '',
                    ];
                }
                if ($count % 2 == 0) {
                    $responses = $this->client->bulk($params);
                    $params = ['body' => []];
                    unset($responses);
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

