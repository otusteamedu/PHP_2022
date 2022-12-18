<?php


namespace Study\Cinema\Service;
use Console_Table;

class Response
{
    public function getTableWithResult($response)
    {
        if(empty($response['hits']['hits'])){
            echo 'Данных по этому запросу нет'.PHP_EOL;
            return ;
        }
        $tbl = new Console_Table();
        $tbl->setHeaders(
            array('Title', 'Category', 'Price','Stock')
        );
        foreach ($response['hits']['hits'] as $row)
        {
            $stocks = '';
            foreach ($row['_source']['stock'] as $stock)
            {
                $stocks.= $stock['shop'].' - '.$stock['stock'].PHP_EOL;
            }
            $tbl->addRow(array($row['_source']['title'], $row['_source']['category'], $row['_source']['price'], $stocks));

        }
        echo $tbl->getTable();
    }

}