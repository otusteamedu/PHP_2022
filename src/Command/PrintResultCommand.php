<?php

namespace Command;

class PrintResultCommand
{
    /**
     * @param array $result
     * @return void
     */
    public function execute(array $result): void
    {
        $answer = "Title  SKU  Category  Stock\n";
        foreach ($result as $hit) {
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
