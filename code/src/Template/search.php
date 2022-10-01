<?php

echo
<<<TABLE
--------------------------------------------------------------------------------------------------------------------------
| id/sku |               Title                              |  Price |        Category        |  Shop  | Stock |  Score  |
--------------------------------------------------------------------------------------------------------------------------
TABLE . PHP_EOL;

foreach ($result['hits']['hits'] as $item) {
    foreach ($item['_source']['stock'] as $stock) {
        echo '|' . sprintf("%' -8s", $item['_id']) .
            '|' . $item['_source']['title'] . str_repeat(' ', 50 - mb_strlen($item['_source']['title'])) .
            '|' . str_pad($item['_source']['price'], 8, ' ', STR_PAD_RIGHT) .
            '|' . $item['_source']['category'] . str_repeat(' ', 24 - mb_strlen($item['_source']['category'])) .
            '|' . $stock['shop'] . str_repeat(' ', 8 - mb_strlen($stock['shop'])) .
            '|' . sprintf("%' -7s", $stock['stock']) .
            '|' . $item['_score'] . '|' . PHP_EOL;
    }
}

echo str_repeat('-', 122) . PHP_EOL;
