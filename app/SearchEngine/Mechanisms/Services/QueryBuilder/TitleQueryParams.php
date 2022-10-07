<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder;

use App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts\ElasticsearchQueryParams;

final class TitleQueryParams implements ElasticsearchQueryParams
{
    /**
     * @param string $field_name
     * @param string $field_value
     * @return \string[][][]
     */
    public static function getParam(string $field_name, string $field_value): array
    {
        return [
            'match' => [
                $field_name => [
                    'query' => $field_value,
                    'fuzziness' => 'auto',
                ],
            ]
        ];
    }
}
