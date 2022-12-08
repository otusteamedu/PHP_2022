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
     * @param array $filterParams
     * @return array
     */
    private static function getParamsFromResponse(array $filterParams)
    {
        $filterParams = array_slice($filterParams,3);
        $arSubCmd = ['-t','-c','-p','-a'];
        //объединение раздельных слов в строки за исключением команд
        foreach($filterParams as $k => $v){
            if(!in_array($v,$arSubCmd) && !empty($filterParams[$k+1]) && !in_array($filterParams[$k+1],$arSubCmd)) {
                $filterParams[$k + 1] = $v . " " . $filterParams[$k + 1];
                unset($filterParams[$k]);
            }
        }

        $t = array_search('-t',$filterParams);
        $c = array_search('-c',$filterParams);
        $p = array_search('-p',$filterParams);
        $title = $t !== false && isset($filterParams[$t+1]) && !in_array($filterParams[$t+1],$arSubCmd) ? $filterParams[$t+1] : "";
        $category = $c !== false && isset($filterParams[$c+1]) && !in_array($filterParams[$c+1],$arSubCmd) ? $filterParams[$c+1] : "";
        $toPrice = $p !== false && isset($filterParams[$p+1]) && !in_array($filterParams[$p+1],$arSubCmd) ? (int)$filterParams[$p+1] : 0;
        $available = array_search('-a',$filterParams);
        return [$title,$category,$toPrice,$available];
    }

    /**  Формирование тела запроса для фильтрации
     * @param array $filterParams
     * @return \array[][][]
     */
    public static function getBodyForFilter(array $filterParams): array
    {
        list($title,$category,$toPrice,$available) = self::getParamsFromResponse($filterParams);
        $match = [];
        $filter = [];
        if (!empty($category))
            $match[] = [
              "match" => [
                "category" => (string)$category
              ]
            ];
        if (!empty($title))
            $match[] = [
              "match" => [
                "title" => [
                  "query" => (string)$title,
                  "fuzziness" => "auto"
                ]
              ]
            ];
        if (!empty($toPrice))
            $filter[] = [
              'range' => [
                'price' => [
                  'lte' => (int)$toPrice
                ]
              ]
            ];
        if (!empty($available))
            $filter[] = [
              'nested' => [
                'path' => 'stock',
                'query' => [
                  [
                    'range' => [
                      'stock.stock' => [
                        'gte' => 1
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