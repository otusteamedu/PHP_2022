<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder;

use App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts\ElasticsearchQueryParams;

final class ShopQueryParams implements ElasticsearchQueryParams
{
    /**
     * @param string $field_name
     * @param string $field_value
     * @return array[]
     */
    public static function getParam(string $field_name, string $field_value): array
    {
        return [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'must' => [
                            'match' => [
                                'stock.' . $field_name => $field_value
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
