<?php

namespace app\models;

class Book implements ModelInterface {

    public function showHitsTable(array $hits): string {
        if (count($hits) == 0) {
            return '';
        }
        $return = 'sku | title | category | price | stock'.PHP_EOL;
        foreach ($hits as $hit) {
            $s = $hit['_source'];
            $stock = '';
            foreach ($s['stock'] as $sInfo) {
                $stock.= 'Магазин на '.$sInfo['shop'].': '.$sInfo['stock'].'. ';
            }
            $return .= $s['sku'].' | '.$s['title'].' | '.$s['category'].' | '.$s['price'].' | '.$stock.PHP_EOL;
        }
    }
}
