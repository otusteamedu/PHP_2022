<?php

declare(strict_types=1);

namespace Otus\App\Core;

use Otus\App\Entity\Book;
use Otus\App\Entity\Stock;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticClient implements RepositoryInterface
{
    private const LIMIT = 11;
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();
    }

    public function search(array $params): array
    {
        $preparedParams = $this->getPreparedParams($params);
        $response = $this->client->search($preparedParams);
        $responseAsArray = $response->asArray()['hits']['hits'];
        return $this->formatResult($responseAsArray);
    }

    private function formatResult(array $result): array
    {
        $preparedResult = [];
        foreach ($result as $bookInfo) {
            $book = new Book(
                book_dto: new BookDTO(
                    sku: $bookInfo['_source']['sku'],
                    title: $bookInfo['_source']['title'],
                    category: $bookInfo['_source']['category'],
                    price: $bookInfo['_source']['price']
                )
            );
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
            'index' => 'otus-shop',
            'body' => [
                'size' => $limit ?? self::LIMIT,
                'from' => $offset ?? 0,
                'query' => $conditions,
            ],
        ];
    }
}
