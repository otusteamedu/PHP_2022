<?php

namespace Otus\Task12\App\Controllers;

use Otus\Task12\App\Controller;
use Otus\Task12\App\Infrastructure\ProductEntity;


class HomeController extends Controller
{
    public function index(): void
    {
        $entityManager = new \Otus\Task12\Core\ORM\EntityManager();
        $allEntities = $entityManager->getRepository(ProductEntity::class)->all();
        $firstEntity = $entityManager->getRepository(ProductEntity::class)->find(3);
        $firstEntity = $entityManager->getRepository(ProductEntity::class)->find(3);


        $productEntity = new ProductEntity();
        $productEntity->setName('test_' . rand(1, 10000));
        $productEntity = $entityManager->create($productEntity);

        $productEntity->setName('update');
        $entityManager->update($productEntity);

        $entityManager->delete($productEntity);
    }
}