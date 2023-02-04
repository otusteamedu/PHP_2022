<?php

namespace Otus\Task12\App\Infrastructure;

use Otus\Task12\Core\Transform;

class ProductEntityTransform
{
    public function transform(mixed $item): ProductEntity
    {
       $productEntity =  new ProductEntity();
       $productEntity->setId($item['id']);
       $productEntity->setName($item['title']);
       return $productEntity;
    }
}