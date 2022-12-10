<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\QueryBuilder;


class QueryBuilder
{
    const DEFAULT_LIMIT = 20;

    public function __construct()
    {
    }

    public function build($options): array
    {

        $conditions = [];

        if (isset($options['t']) || isset($options['title'])) {
            $conditions['match']['title']['query'] = isset($options["t"]) ? $options["t"] : $options["title"];

            if ((isset($options['f']) || isset($options['fuzziness'])) && !empty($conditions)) {
                $conditions['match']['title']['fuzziness'] = isset($options["f"]) ? $options["f"] : $options["fuzziness"];
            } else {
                $conditions['match']['title']['fuzziness'] = 'auto';
            }
        }

        if (isset($options['i']) || isset($options['sku'])) {
            $conditions['term']['sku']['value'] = isset($options["i"]) ? $options["i"] : $options["sku"];
        }

        if (isset($options['c']) || isset($options['category'])) {
            $conditions['term']['category']['value'] = isset($options["c"]) ? $options["c"] : $options["category"];
        }

        if (isset($options['s']) || isset($options['stock'])) {
            $stock = isset($options["s"]) ? $options["s"] : $options["stock"];
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
                                'value' => $stock,
                            ],
                        ],
                    ],
                ],
            ];
        }

        if (isset($options['l']) || isset($options['low_price'])) {
            $lowPrice = isset($options["l"]) ? $options["l"] : $options["low_price"];
            $conditions['range']['price'] = [
                'gte' => $lowPrice,
            ];
        }

        if (isset($options['h']) || isset($options['high_price'])) {
            $highPrice = isset($options["h"]) ? $options["h"] : $options["high_price"];
            $conditions['range']['price'] = [
                'lte' => $highPrice,
            ];
        }

        if (isset($options['g']) || isset($options['limit'])) {
            $limit = isset($options["g"]) ? (int)$options["g"] : (int)$options["limit"];
        }

        if (empty($conditions)) {
            $conditions = [
                'match_all' => (object)[]
            ];
        }


        $queryParams = [
            'index' => 'otus-shop',
            'body' => [
                'query' => $conditions,
                'size' => $limit ?? self::DEFAULT_LIMIT
            ]
        ];
        return $queryParams;
    }

}