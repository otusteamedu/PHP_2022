<?php


namespace Study\Cinema\Service;
use Study\Cinema\Exception\ArgumentException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Console_Table;

class Response
{
    public function getTableWithResult(array $headers,array $columns,  Elasticsearch $response)
    {
        if(empty($response['hits']['hits'])){
            throw new ArgumentException('Данных по этому запросу нет'.PHP_EOL);
        }
        $tbl = new Console_Table();
        $tbl->setHeaders(
            $headers
        );
        foreach ($response['hits']['hits'] as $row)
        {
            $rowColumns = [];
            foreach($columns as $column) {
                if(is_array($column)) {
                   $columnName = array_keys($column)[0];
                   $arrayColumnResult = '';
                   foreach ($row['_source'][$columnName] as $arrayColumn)
                   {
                       $count = count($column[$columnName]);
                       for( $i=0; $i < $count; $i++ ){
                           if($i) $arrayColumnResult.= '-';
                           $arrayColumnResult.= $arrayColumn[$column[$columnName][$i]];
                       }
                       $arrayColumnResult .= PHP_EOL;
                   }
                   array_push($rowColumns,$arrayColumnResult);
                }
                else
                    array_push($rowColumns,$row['_source'][$column]);
            }
            $tbl->addRow($rowColumns);
        }
        echo $tbl->getTable();
    }

}