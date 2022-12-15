<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

class InputHandler
{
    private const PARAMS = ['title:', 'category:', 'max_cost:', 'in_stock'];

    public static function getParams(): array
    {
        $inputParams = getopt('', self::PARAMS);

        $preparedParams = [
            'query' => [
                'bool' => []
            ]
        ];

        if (empty($inputParams)) {
            return ['query' => ['match_all' => []]];
        }

        if (array_key_exists('title', $inputParams) && isset($inputParams['title'])) {
            $preparedParams['query']['bool']['must'][] = [
                "match" => ["title" => ["query" => $inputParams['title'], "fuzziness" => "auto"]]
            ];
        }

        if (array_key_exists('category', $inputParams) && isset($inputParams['category'])) {
            $preparedParams['query']['bool']['must'][] = [
                "match" => ["category" => ["query" => $inputParams['category'], "fuzziness" => "auto"]]
            ];
        }

        if (array_key_exists('max_cost', $inputParams) && isset($inputParams['max_cost'])) {
            $preparedParams['query']['bool']['filter'][] = [
                "range" => ["price" => ["lt" => $inputParams['max_cost']]]
            ];
        }

        if (array_key_exists('in_stock', $inputParams)) {
            $preparedParams['query']['bool']['filter'][] = [
                "nested" => [
                  "path" => 'stock',
                  'query' => ['range' => ['stock.stock' => [ 'gte' => 1]]]
                ]
            ];
        }

        return $preparedParams;
    }
}
