<?php

namespace app\actions;

use app\EsSearcher;

class SearchAction extends Action {
    private array $preparedParams = [];
    private const ALLOWED_PARAMS = ['minStock', 'minPrice', 'maxPrice', 'category', 'title'];

    public function execute()
    {
        $this->prepareParams();
        $searcher = new EsSearcher($this->index, $this->preparedParams);

        return $this->pretty($searcher->search());
    }

    private function prepareParams(): void
    {
        $priceParam = [];
        foreach ($this->params as $param) {
            $paramArr = explode(':', $param);
            if (!isset($paramArr[1])) throw new \Exception('Неверный формат параметра: ' . $param . '. Используйте формат param:value.');
            if (!in_array($paramArr[0], self::ALLOWED_PARAMS)) throw new \Exception('Неизвестный параметр: ' . $paramArr[0] . '. Разрешенные параметры: ' . implode(', ', self::ALLOWED_PARAMS));

            $this->preparedParams = [];

            switch ($paramArr[0]) {
                case 'minStock':
                    $filter = [
                        'nested' => [
                            'path' => "stock",
                            'query' => [
                                'bool' => [
                                    'filter' => [
                                        0 => [
                                            'range' => [
                                                'stock.stock' => [ "gte" => $paramArr[1] ]
                                            ]
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ];
                    $this->preparedParams['bool']['filter'][] = $filter;
                    break;
                case 'minPrice':
                    $p = ['range' => ['price' => ['gte' => $paramArr[1]]]];
                    $priceParam = array_merge_recursive($priceParam, $p);
                    break;
                case 'maxPrice':
                    $p = ['range' => ['price' => ['lt' => $paramArr[1]]]];
                    $priceParam = array_merge_recursive($priceParam, $p);
                    break;
                case 'category':
                    $this->preparedParams['bool']['filter'][]['term']['category'] = $paramArr[1];
                    break;
                case 'title':
                    $this->preparedParams['bool']['must']['match']['title'] = ['query' => $paramArr[1], 'fuzziness' => 'auto'];
                    break;
            }

        }
        if (!empty($priceParam)) {
            $this->preparedParams['bool']['filter'][] = $priceParam;
        }
    }
    public function pretty($result): string
    {
        if (!isset($result['hits']) || !isset($result['hits']['hits']) || count($result['hits']['hits']) == 0) {
            return 'Ничего не найдено. Попробуйте расширить фильтры.'.PHP_EOL;
        }

        return $this->model->showHitsTable($result['hits']['hits']);
    }
}
