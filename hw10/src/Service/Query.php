<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10\Service;

use VeraAdzhieva\Hw10\Service\InputParams;

class Query
{
    private InputParams $inputParams;

    public function __construct(InputParams $inputParams)
    {
        $this->inputParams = $inputParams;
    }

    public function getParam()
    {
        $params = [
            'index' => 'otus-shop',
            'body' => $this->getQuery($this->inputParams)
        ];
        return $params;
    }

    private function getQuery($inputParams)
    {
        $data = [
            'query' => [
                'bool' => []
            ]
        ];

        if (array_key_exists('title', $inputParams) && isset($inputParams['title'])) {
            $data['query']['bool']['must'][] = [
                "match" => ["title" => ["query" => $inputParams['title'], "fuzziness" => "auto"]]
            ];
        }

        if (array_key_exists('category', $inputParams) && isset($inputParams['category'])) {
            $data['query']['bool']['must'][] = [
                "match" => ["category" => ["query" => $inputParams['category'], "fuzziness" => "auto"]]
            ];
        }

        if (array_key_exists('price', $inputParams) && isset($inputParams['max_cost'])) {
            $data['query']['bool']['filter'][] = [
                "range" => ["price" => ["lt" => $inputParams['max_cost']]]
            ];
        }

        if (array_key_exists('in_stock', $inputParams)) {
            $data['query']['bool']['filter'][] = [
                "nested" => [
                    "path" => 'stock',
                    'query' => ['range' => ['stock.stock' => [ 'gte' => 1]]]
                ]
            ];
        }

        return $data;
    }
}