<?php

namespace Command;

use Elastic\Elasticsearch\Response\Elasticsearch;

class PrintResultCommand
{
    public function execute(Elasticsearch $result)
    {
        $answer = "Title  SKU  Category  Stock\n";
        foreach ($result['hits']['hits'] as $hit) {
            $answer .= $hit['_source']['title']
                . ' ' . $hit['_source']['sku']
                . ' ' . $hit['_source']['category']
                . ' ' . $hit['_source']['price'];
            foreach ($hit['_source']['stock'] as $shop) {
                $answer .= 'stock: ' . $shop['shop'] . "count: " . $shop['stock'];
            }

            $answer .= PHP_EOL;
        }

        echo $answer;
    }
}
