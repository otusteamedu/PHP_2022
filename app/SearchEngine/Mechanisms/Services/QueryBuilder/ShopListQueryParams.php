<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder;

use App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts\ElasticsearchQueryParams;

final class ShopListQueryParams implements ElasticsearchQueryParams
{
    public static function getParam(string $field_name, string $field_value): array
    {
        $query_params = [];

        $tmp_field_value_parts = explode(separator: ',', string: $field_value);
        $tmp_field_name_parts = explode(separator: '_', string: $field_name);

        foreach ($tmp_field_value_parts as $tmp_field_value_part) {
            $query_params = [
                'nested' => [
                    'path' => 'stock',
                    'query' => [
                        'bool' => [
                            'must' => [
                                'match' => [
                                    'stock.' . $tmp_field_name_parts[0] => [
                                        'query' => $tmp_field_value_part,
                                        'fuzziness' => 'auto',
                                    ],
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        return $query_params;
    }
}
