<?php

declare(strict_types=1);

namespace Nemizar\OtusShop;

use Elastic\Elasticsearch\Client;
use Nemizar\OtusShop\config\Config;
use Nemizar\OtusShop\render\OutputInterface;

class BookSearch
{
    private Config $config;

    private Client $client;

    private OutputInterface $output;

    private const LIMIT = 25;

    public function __construct(Config $config, Client $client, OutputInterface $output)
    {
        $this->client = $client;
        $this->config = $config;
        $this->output = $output;
    }

    public function search(array $paramsForSearch): void
    {
        $params = $this->getParams($paramsForSearch);
        $response = $this->client->search($params);

        $result = $response->asArray()['hits']['hits'];
        $this->output->echo($result);
    }

    private function getParams(array $paramsForSearch): array
    {
        $conditions = [];
        foreach ($paramsForSearch as $name => $value) {
            switch ($name) {
                case 'title':
                    $conditions['match'][$name] = [
                        'query' => $value,
                        'fuzziness' => "auto",
                    ];
                    break;
                case 'sku':
                case 'category':
                    $conditions['term'][$name] = [
                        'value' => $value,
                    ];
                    break;
                case 'in_stock':
                    $conditions['nested'] = [
                        'path' => 'stock',
                        'query' => [
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gt' => '0',
                                    ],
                                ],
                            ],
                            [
                                'term' => [
                                    'stock.shop' => [
                                        'value' => $value,
                                    ],
                                ],
                            ],
                        ],
                    ];
                    break;
                case 'price_from':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'gte' => $value,
                    ];
                    break;
                case 'price_to':
                    if (!$value) {
                        break;
                    }
                    $conditions['range']['price'] = [
                        'lte' => $value,
                    ];
                    break;
                case 'limit':
                    $limit = (int)$value;
                    break;
                case 'offset':
                    $offset = (int)$value;
            }
        }

        if (empty($conditions)) {
            $conditions = [
                'match_all' => (object)[],
            ];
        }

        return [
            'index' => $this->config->index,
            'body' => [
                'size' => $limit ?? self::LIMIT,
                'from' => $offset ?? 0,
                'query' => $conditions,
            ],
        ];
    }
}
