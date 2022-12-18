<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Domain\ProductInterface;
use Otus\App\Application\Proxy\TasterProducts;
use Otus\App\Application\Strategies\Cook;
use Otus\App\Domain\AdditionalIngredientsInterface;
use Otus\App\Application\Observer\ObserverMailer;
use Otus\App\Application\Controllers\Product;

class App
{
    public function run()
    {
        //Для Паттерна Наблюдатель.
        $observer = new ObserverMailer;
        //Блюдо
        $products = [];

        //Заказ
        $order =[
            [
                ProductInterface::TYPE_BURGER,
                [AdditionalIngredientsInterface::ADD_CHEESE]
            ],
            [
                ProductInterface::TYPE_SANDWICH,
                [AdditionalIngredientsInterface::ADD_SAUCE]
            ],
            [
                ProductInterface::TYPE_HOTDOG,
                [AdditionalIngredientsInterface::ADD_CARROT]
            ],
        ];


        //Что нужно приготовить? Паттерн СТРАТЕГИЯ и привязка к Наблюдателю
        foreach ($order as $item) {
            $products[] = (new Cook())->Prepare($item[0], $item[1])->attach($observer);
        }

        //Проверить еду на соответствие стандарту. Паттерн ПРОКСИ
        foreach ($products as $i=>$product) {
            if (!(new TasterProducts($product))->standardsCompliance()) {
                echo $product->getName()." - ОПАСНО ДЛЯ ЖИЗНИ! НЕ ЕШЬ МЕНЯ.".PHP_EOL;
                unset($products[$i]);
            } else {
                $product->changeReadyStatus(Product::READY_STATUS);
            }
        }
    }
}
