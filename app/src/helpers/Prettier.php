<?php

namespace app\helpers;

class Prettier {

    public static function showBooksTable(array $bookHits): string {
        $return = 'sku | title | category | price | stock'.PHP_EOL;
        foreach ($bookHits as $hit) {
            $s = $hit['_source'];
            $stock = '';
            foreach ($s['stock'] as $sInfo) {
                $stock.= 'Магазин на '.$sInfo['shop'].': '.$sInfo['stock'].'. ';
            }
            $return .= $s['sku'].' | '.$s['title'].' | '.$s['category'].' | '.$s['price'].' | '.$stock.PHP_EOL;
        }
        return $return;
    }

}
