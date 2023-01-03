<?php

declare(strict_types=1);

namespace HW10\App\Queries;

use HW10\App\DTO\StoreDTO;
use HW10\App\Interfaces\QueryInterface;

class SearchProductQuery implements QueryInterface
{
    protected const ELEMENTS_LIMIT = 25;

    private const FIELDS = [
        'title:',
        'sku:',
        'category:',
        'in_stock:',
        'price_from:',
        'price_to:',
        'limit:',
        'offset:',
    ];

    public function getParams(): array
    {
        return \getopt(
            '',
            self::FIELDS
        );
    }

    public function getPreparedParams(): array
    {
        $params = $this->getParams();
        return $this->prepare($params);
    }

    public static function prepareResponse(array $response, $dto): array
    {
        $preparedResult = [];
        foreach ($response as $responseElement) {
            $dtoObj = new $dto(
                $responseElement['_source']['sku'],
                $responseElement['_source']['title'],
                $responseElement['_source']['category'],
                $responseElement['_source']['price']
            );
            foreach ($responseElement['_source']['stock'] as $stockInfo) {
                $dtoObj->addStores(new StoreDTO($stockInfo['shop'], $stockInfo['stock']));
            }
            $preparedResult[] = $dtoObj;
        }

        return $preparedResult;
    }

    public function prepare(array $params): array
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
            'index' => $_ENV['ELASTIC_INDEX'],
            'body' => [
                'size' => $limit ?? self::ELEMENTS_LIMIT,
                'from' => $offset ?? 0,
                'query' => $conditions,
            ],
        ];
    }
}
