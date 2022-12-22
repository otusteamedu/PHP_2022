<?php

namespace Otus\App\Application\Strategies;

use Otus\App\Application\AbstractFactory\AbstractFactory;
use Otus\App\Application\Decorators;
use Otus\App\Domain\Model\Controllers\Product;
use Otus\App\Domain\Model\Interface\AdditionalIngredientsInterface;

class Cook
{
    public function Prepare(int $productType, array $additions) : Product
    {
        $chef = AbstractFactory::getFactory();
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