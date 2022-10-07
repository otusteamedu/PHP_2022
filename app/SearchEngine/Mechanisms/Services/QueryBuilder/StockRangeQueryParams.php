<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder;

use App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts\ElasticsearchQueryParams;

final class StockRangeQueryParams implements ElasticsearchQueryParams
{
    /**
     * @param string $field_name
     * @param string $field_value
     * @return array[]
     */
    public static function getParam(string $field_name, string $field_value): array
    {
        $tmp_field_value_parts = explode(separator: '-', string: $field_value);
        $tmp_field_name_parts = explode(separator: '_', string: $field_name);

        $gte = (int) $tmp_field_value_parts[0];
        $lte = (int) $tmp_field_value_parts[1];

        return [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'must' => [
                            'range' => [
                                'stock' . $tmp_field_name_parts[0] => [
                                    'gte' => $gte,
                                    'lte' => $lte,
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
