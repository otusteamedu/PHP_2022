<?php

namespace Ppro\Hw12\Elasticsearch;

use Ppro\Hw12\Helpers\AppContext;
use \Elastic\Elasticsearch\Response\Elasticsearch as LibResponse;

class Response
{
    /** Форматирование результата выполнения _bulk
     * @param AppContext $context
     * @param LibResponse $response
     * @param string $key
     * @return void
     */
    public static function setBulkResultToContext(AppContext $context, LibResponse $response, string $key = "RESULT"): void
    {
        $result = $response->asArray();
        $resultSting = "Request completed ".($result['errors'] ? "with" : "without")." errors"."\r\n";
        $context->setValue($key, $resultSting);
    }

    /** Форматирование результата выполнения delete
     * @param AppContext $context
     * @param LibResponse $response
     * @param string $key
     * @return void
     */
    public static function setDeleteResultToContext(AppContext $context, LibResponse $response, string $key = "RESULT"): void
    {
        $result = $response->asArray();
        $resultSting = "Document has ".($result['acknowledged'] ? "" : "not")." been deleted"."\r\n";
        $context->setValue($key, $resultSting);
    }

    /** Вывод таблицы с результатами поиска
     * @param AppContext $context
     * @param LibResponse $response
     * @param string $key
     * @return void
     */
    public static function setSearchResultToContext(AppContext $context, LibResponse $response, string $key = "RESULT"): void
    {
        $result = $response->asArray();

        $resultString = "\r\n";
        $resultString .= "Total docs: ". $result['hits']['total']['value']."\r\n";
        $resultString .= "Max score : ". $result['hits']['max_score']."\r\n";
        $resultString .= "Took      : ". $result['took']."\r\n";

        if(empty($result['hits']['hits'])){
            $context->setValue($key, $resultString."No results found");
            return;
        }

        $tbl = new \Console_Table();
        $first = reset($result['hits']['hits']);
        $tbl->setHeaders(array_keys($first['_source']));
        array_walk($result['hits']['hits'],fn($v) => $tbl->addRow(array_map(fn($v)=> is_scalar($v) ? $v : json_encode($v,JSON_UNESCAPED_UNICODE),$v['_source'])));

        $context->setValue($key, $resultString.$tbl->getTable());
    }
}