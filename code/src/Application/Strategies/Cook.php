<?php

namespace Otus\App\Application\Strategies;

use Otus\App\Application\Controllers\Product;
use Otus\App\Application\AbstractFactory\ProductAbstractFactory;
use Otus\App\Domain\AdditionalIngredientsInterface;
use Otus\App\Application\Decorators;

class Cook
{
    public function Prepare(int $productType, array $additions) : Product
    {
        $chef = new ProductAbstractFactory();
        $product = $chef->create($productType)->create();

        //Добавляем дополнительные ингредиенты. Паттерн ДЕКОРАТОР
        foreach ($additions as $addition)
        {
            switch($addition)
            {
                case AdditionalIngredientsInterface::ADD_CHEESE:
                    $product = new Decorators\AddCheese($product);
                    break;
                case AdditionalIngredientsInterface::ADD_CARROT:
                    $product = new Decorators\AddCarrot($product);
                    break;
                case AdditionalIngredientsInterface::ADD_PEPPER:
                    $product = new Decorators\AddPepper($product);
                    break;
                case AdditionalIngredientsInterface::ADD_BACON:
                    $product = new Decorators\AddBacon($product);
                    break;
                case AdditionalIngredientsInterface::ADD_SAUCE:
                    $product = new Decorators\AddSauce($product);
                    break;
            }
        }
        return $product;
    }
}