<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\Controllers\DeliveryService;
use App\Application\Factories;
use App\Application\Controllers\Product;
use App\Application\Proxies\FinalQualityTester;
use App\Application\Strategies\Kitchen;
use App\Domain\Contracts\ExtraOptionsInterface;
use App\Infrastructure\Services\DummySms;
use App\Domain\Contracts\ProductInterface;

class App
{
    public function run(){

        //Создаем наблюдателя - служба доставки
        $deliveryService = new DeliveryService(new DummySms());

        //Заказ, что нужно приготовить
        $order =[
            [
                ProductInterface::TYPE_HOTDOG,
                [ExtraOptionsInterface::EXTRA_ONION, ExtraOptionsInterface::EXTRA_PEPPER]
            ],
            [
                ProductInterface::TYPE_HOTDOG,
                []
            ],
            [
                ProductInterface::TYPE_SANDWICH,
                [ExtraOptionsInterface::EXTRA_PEPPER, ExtraOptionsInterface::EXTRA_CHEESE]
            ],
            [
                ProductInterface::TYPE_BURGER,
                [ExtraOptionsInterface::EXTRA_PEPPER]
            ],
            [
                ProductInterface::TYPE_BURGER,
                [ExtraOptionsInterface::EXTRA_PEPPER, ExtraOptionsInterface::EXTRA_ONION]
            ],
        ];

        //Готовые изделия
        $products = [];

        //Их готовим через стретигию
        foreach ($order as $item)
        {
            $products[] = (new Kitchen())->Prepare($item[0], $item[1])->attach($deliveryService);
        }

        //Дальше через прокси проверяем качество продукта.
        foreach ($products as $i=>$product)
        {
            if (!(new FinalQualityTester($product))->isEveryfingFine())
            {
                echo $product->getName()." - утиллизирован. Некачественный.".PHP_EOL;
                unset($products[$i]);   //Утилизируем
            }
        }

        //Распечатываем заказ и передаем через наблюдателя шлем событие о готовности к достаке
        $summ = 0.0;
        foreach ($products as $i=>$product)
        {
            $summ += $product->getPrice();
            echo $product->getName()." (".$product->getPrice()." р.) ".PHP_EOL;
            $product->changePreparingStage(Product::READY_TO_DELIVER);
        }

        echo "Итого: ". $summ. " р.";
    }

}