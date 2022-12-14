<?php


namespace Study\Cinema\Service;
use Study\Cinema\Service\ArgumentCreator;

class QueryCreator
{
    private ArgumentCreator $arguments;
    private string $query;
    public function __construct(ArgumentCreator $argumentCreator)
    {
        $this->arguments = $argumentCreator;
    }

    private function getQueryString()
    {
        $this->query ='{
          "query": {
            "bool":
            {
                "must": [
                { 
                      "match": { 
                                    "title":
                                    {
                                        "query": "'.$this->arguments->getTitle().'" ,
                                        "fuzziness": "auto"
                                    }
                                }
                }],
                "filter": [';
        if(!empty($this->arguments->getCategory()))
            $this->query .=      '{
                                  "match_phrase": {
                                    "category": "'.$this->arguments->getCategory().'"
                              }},';

        if(!empty($this->arguments->getPrice()))
            $this->query .='{ "range": { "price": { "lte": '.$this->arguments->getPrice().' } } },';
        $this->query .=' { "range": { "stock.stock": { "gt": 0 } } }
                ]
            }
         }
       }';


    }

    public function getParam()
    {
       $this->getQueryString();
       $params = [
            'index' => 'otus-shop',
            'body' => $this->query
       ];

        return $params;
    }
    
}