<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder;

use App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts\ElasticsearchQueryParams;

final class CategoryListQueryParams implements ElasticsearchQueryParams
{
    /**
     * @param string $field_name
     * @param string $field_value
     * @return array|\array[][]
     */
    public static function getParam(string $field_name, string $field_value): array
    {
        $query_params = [];

        $tmp_field_value_parts = explode(separator: ',', string: $field_value);
        $tmp_field_name_parts = explode(separator: '_', string: $field_name);

        foreach ($tmp_field_value_parts as $tmp_field_value_part) {
            $query_params = [
                'match' => [
                    $tmp_field_name_parts[0] => [
                        'query' => $tmp_field_value_part,
                        'fuzziness' => 'auto',
                    ],
                ]
            ];
        }

        return $query_params;
    }
}
