<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Services\QueryBuilder\Contracts;

interface ElasticsearchQueryParams
{
    public static function getParam(string $field_name, string $field_value): array;
}
