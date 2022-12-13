<?php

namespace Study\Cinema;

use Elastic\Elasticsearch\ClientBuilder;
use Console_Table;
use http\Env\Response;

class App
{
    private string|null $title;
    private string|null $category;
    private bool|null $help;
    private string|null $response;

    public function __construct($options)
    {

        $this->setTitle($options);
        $this->setCategory($options);
        $this->setHelp($options);

    }
    public function run()
    {
        if(!$this->checkOption())
        {
            echo $this->response;
            return;
        }
        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();

        $response = $client->search($this->getParams());
       // print_r($response['hits']['hits']);
        echo $this->getTableWithResult($response);


    }


    private function setCategory($options)
    {
        $this->category = $options['c'] ?? $options['category'] ?? null;
    }

    private function setTitle($options)
    {
        $this->title =  $options['t'] ?? $options['title'] ?? null;
    }

    private function setHelp($options)
    {
        if(array_key_exists('h', $options) || array_key_exists('help', $options)){
            $this->help = true;
        }
        else
            $this->help = false;
    }

    private function getTitle(): ?string
    {
        return $this->title;
    }

    private function getCategory(): ?string
    {
        return $this->category;
    }
    private function getHelp(): bool
    {
        return $this->help;
    }

    private function checkOption()
    {
        if($this->help) {
            $this->response = 'Используйте ключи для поиска: --title(-t) - по имени, --category(-c) - по категории. \n   '.PHP_EOL;
            return false;
        }
        else if(!$this->title) {
            $this->response = 'Параметр --title(-t) обязательный.'.PHP_EOL;
            return false;
        }
        else
            return true;

    }

    private function getParams()
    {
        $query ='{
          "query": {
            "bool":
            {
                "must": [
                { 
                      "match": { 
                                    "title":
                                    {
                                        "query": "'.$this->title.'" ,
                                        "fuzziness": "auto"
                                    }
                                }
                }],
                "filter": [';
        if(!empty($this->category))
            $query .=      '{
                              "match_phrase": {
                                "category": "'.$this->category.'"
                          }},';
        $query .='
                    { "range": { "price": { "lte": 2500, "gte": 1000 } } },
                    { "range": { "stock.stock": { "gt": 0 } } }
                ]
            }
         }
       }';

        $params = [
            'index' => 'otus-shop',
            'body' => $query
        ];

        return $params;

    }
    private function getTableWithResult($response)
    {
        if(empty($response['hits']['hits'])){
            return null;
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
        return $tbl->getTable();
    }


}
