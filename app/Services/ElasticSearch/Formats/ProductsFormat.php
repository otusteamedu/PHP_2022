<?php

namespace Otus\Task10\App\Services\ElasticSearch\Formats;

class ProductsFormat
{
    private array $products;
    private array $fields = ['title', 'sku', 'category', 'in_stock'];
    public function __construct(array  $products){
        $this->products = $products["hits"]["hits"];
    }

    public function getProducts(): array{
       $products = [];
       foreach ($this->products as $value){
           $product = $value['_source'];
           $values = [];
           foreach($this->getFields() as $field){
               if($field === 'in_stock'){
                   $values[] =  (bool)$product["stock"];
               }else{
                   $values[] =  $product[$field];
               }
           }
           $products[] = $values;
       }
       return $products;
    }

    public function getFields(){
        return $this->fields;
    }

    public function setFields(array $fields){
        $this->fields = $fields;
    }
}