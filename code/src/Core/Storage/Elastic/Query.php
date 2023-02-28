<?php

declare(strict_types=1);

namespace Kogarkov\Es\Core\Storage\Elastic;

class Query
{
    private $client;
    private $index_name;

    public function __construct(object $client, string $index_name)
    {
        $this->client = $client;
        $this->index_name = $index_name;
        $this->init();
    }

    private function init(): void
    {
        if (!$this->indexIsExists()) {
            throw new \Exception("Index $this->index_name not exists");
        }
    }

    private function indexIsExists(): bool
    {
        return $this->client->indices()->exists(['index' => $this->index_name])->asBool();
    }

    public function search(array $filter)
    {
        $search = [
            'index' => $this->index_name,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => [
                                'title' => [
                                    'query' => $filter['query'],
                                    'fuzziness' => 'auto'
                                ]
                            ]]
                        ]
                    ]
                ]
            ]
        ];

        if (!empty($filter['category'])) {
            $search['body']['query']['bool']['must'][]['term'] = [
                'category' => $filter['category']
            ];
        }

        if (!empty($filter['maxprice'])) {
            $search['body']['query']['bool']['must'][]['range'] = [
                'price' => [
                    'gte' => 0,
                    'lt' => $filter['maxprice']
                ]
            ];
        }

        if (!empty($filter['stock'])) {
            $search['body']['query']['bool']['must'][]['nested'] = [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'filter' => [
                            'range' => [
                                'stock.stock' => [
                                    'gte' => 0
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        return $this->client->search($search)->asArray();
    }

    public function getDoc(string $id): object
    {
        return $this->client->get([
            'index' => $this->index_name,
            'id'    => $id
        ]);
    }
}
