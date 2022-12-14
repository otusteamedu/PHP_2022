<?php

namespace Ppro\Hw12\Elasticsearch;

use Ppro\Hw12\Helpers\Json;

class Request
{
    /** Формирование тела запроса для -bulk
     * @param string $filepath
     * @return string[]
     * @throws \Exception
     */
    public static function getBodyForBulk(string $filepath)
    {
        $json = new Json($filepath);
        $cont = trim($json->getContent());
        return explode("\n", $cont);
    }

    /** Формирование параметров для фильтрации из консольной команды
     * @return array
     */
    private static function getParamsFromConsole()
    {
        $consoleParam = \getopt('f:t:c:a:', ['pfrom:', 'pto:']);
        return [
          $consoleParam['t'] ?: "",
          $consoleParam['c'] ?: "",
          $consoleParam['pfrom'] ?? null,
          $consoleParam['pto'] ?? null,
          $consoleParam['a'] ?? null
        ];
    }

    /**  Формирование тела запроса для фильтрации
     * @param array $filterParams
     * @return \array[][][]
     */
    public static function getBodyForFilter(): array
    {
        list($title,$category,$fromPrice,$toPrice,$available) = self::getParamsFromConsole();

        //поиск по category
        $match = [];
        $filter = [];
        if (!empty($category))
            $match[] = [
              "match" => [
                "category" => (string)$category
              ]
            ];

        //поиск по title
        if (!empty($title))
            $match[] = [
              "match" => [
                "title" => [
                  "query" => (string)$title,
                  "fuzziness" => "auto"
                ]
              ]
            ];

        //фильтр по цене
        if(isset($toPrice))
            $priceRange['lte'] = (int)$toPrice;
        if(isset($fromPrice))
            $priceRange['gt'] = (int)$fromPrice;
        if (!empty($priceRange))
            $filter[] = [
              'range' => [
                'price' => $priceRange
              ]
            ];

        //фильтр по доступности
        if (isset($available))
            $filter[] = [
              'nested' => [
                'path' => 'stock',
                'query' => [
                  [
                    'range' => [
                      'stock.stock' => [
                        'gte' => (int)$available ?: 1
                      ]
                    ]
                  ]
                ]
              ]
            ];

        return [
          'query' => [
            'bool' => [
              'must' => $match,
              'filter' => $filter
            ]
          ]
        ];
    }
}