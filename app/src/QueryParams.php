<?php

declare(strict_types=1);

namespace HW10\App;

use HW10\App\DTO\Store;

class QueryParams
{
    private const RESPONSE_SOURCE_FIELDS = [
        'sku' => 'sku',
        'title' => 'title',
        'category' => 'category',
        'price' => 'price',
        'stock' => 'stock'
    ];
    private const ELEMENTS_LIMIT = 25;

    private function getParams(array $options): array
    {
        return \getopt(
            '',
            $options
        );
    }

    public function getPreparedParams(array $options): array
    {
        $params = $this->getParams($options);
        return $this->prepare($params);
    }

    public static function prepareResponse(array $response, $DTO): array
    {
        $preparedResult = [];
        foreach ($response as $responseElement) {
            $dtoObj = new $DTO(
                $responseElement['_source'][self::RESPONSE_SOURCE_FIELDS['sku']],
                $responseElement['_source'][self::RESPONSE_SOURCE_FIELDS['title']],
                $responseElement['_source'][self::RESPONSE_SOURCE_FIELDS['category']],
                $responseElement['_source'][self::RESPONSE_SOURCE_FIELDS['price']]
            );
            foreach ($responseElement['_source'][self::RESPONSE_SOURCE_FIELDS['stock']] as $stockInfo) {
                $dtoObj->addStores(new Store($stockInfo['shop'], $stockInfo['stock']));
            }
            $preparedResult[] = $dtoObj;
        }

        return $preparedResult;
    }

    private function prepare(array $params): array
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
