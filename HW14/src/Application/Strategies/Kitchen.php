<?php

namespace App\Application\Strategies;

use App\Application\Controllers\DeliveryService;
use App\Application\Controllers\Product;
use App\Domain\Contracts\ExtraOptionsInterface;
use App\Domain\Contracts\ProductInterface;
use App\Application\Factories;
use App\Application\Decorators;

class Kitchen
{
    public function Prepare(int $productType, array $additions) : Product
    {
        //Абстрактнаф фабрика
        $producer = new Factories\ProductAbstractFactory();
        $product = $producer->create($productType)->create();
        foreach ($additions as $addition)
        {
            //Добавляем дополнительные опции через декораторы
            switch($addition)
            {
                case ExtraOptionsInterface::EXTRA_ONION:
                    $product = new Decorators\WithExtraOnion($product);
                    break;

                case ExtraOptionsInterface::EXTRA_PEPPER:
                    $product = new Decorators\WithExtraPepper($product);
                    break;

                case ExtraOptionsInterface::EXTRA_CHEESE:
                    $product = new Decorators\WithExtraCheese($product);
                    break;
            }
        }
        return $product;
    }
}