<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\clients;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Nemizar\OtusShop\components\config\Config;
use Nemizar\OtusShop\entity\Book;
use Nemizar\OtusShop\entity\Stock;

class ElasticClient implements RepositoryInterface
{
    private Config $config;

    private const LIMIT = 25;

    private Client $client;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = ClientBuilder::create()
            ->setHosts([$this->config->host])
            ->build();
    }

    /** @inheritDoc */
    public function search(array $params): array
    {
        $preparedParams = $this->getPreparedParams($params);
        $response = $this->client->search($preparedParams);
        $responseAsArray = $response->asArray()['hits']['hits'];
        return $this->formatResult($responseAsArray);
    }

    /**
     * @param Book[] $result
     * @return array
     */
    private function formatResult(array $result): array
    {
        $preparedResult = [];
        foreach ($result as $bookInfo) {
            $book = new Book($bookInfo['_source']['sku'], $bookInfo['_source']['title'], $bookInfo['_source']['category'], $bookInfo['_source']['price']);
            foreach ($bookInfo['_source']['stock'] as $stockInfo) {
                $book->addStock(new Stock($stockInfo['shop'], $stockInfo['stock']));
            }
            $preparedResult[] = $book;
        }
        return $preparedResult;
    }

    private function getPreparedParams(array $params): array
    {
        $conditions = [];
        foreach ($params as $name => $value) {
            switch ($name) {
                case 'title':
                    $conditions['match'][$name] = [
                        'query' => $value,
                        'fuzziness' => 'auto',
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
