<?php

namespace Rs\Rs;

class PrintResult
{


    /**
     * @param ElasticFindBook $books
     * @return void
     */
    public static function print(ElasticFindBook $books):void
    {
        if(empty($books->getResponse()['hits']['hits'])){
             return;
        }
        $result='Название | Номер | Категория | Цена '.PHP_EOL;
        foreach ($books->getResponse()['hits']['hits'] as $book){
            $book=$book['_source'];
            $result.=$book['title'] . ' | ' . $book['sku'] . ' | ' . $book['category'] . ' | ' . $book['price'].PHP_EOL;
        }
        echo $result;
    }
}
