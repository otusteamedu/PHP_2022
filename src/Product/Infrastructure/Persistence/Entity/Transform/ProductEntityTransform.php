<?php

namespace Otus\Task13\Product\Infrastructure\Persistence\Entity\Transform;


use Otus\Task13\Product\Infrastructure\Persistence\Entity\ProductEntityPersistence;

class ProductEntityTransform
{
    public function transform(mixed $item): ProductEntityPersistence
    {
        $productEntity = new ProductEntityPersistence();
        $productEntity->setId($item['id']);
        $productEntity->setName($item['title']);
        return $productEntity;
    }
}