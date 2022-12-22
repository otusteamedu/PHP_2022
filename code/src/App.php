<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Application\Observer\ObserverMailer;
use Otus\App\Application\Proxy\TasterProducts;
use Otus\App\Application\Strategies\Cook;
use Otus\App\Domain\Model\Controllers\Product;
use Otus\App\Domain\Model\Interface\AdditionalIngredientsInterface;
use Otus\App\Domain\Model\Interface\ProductInterface;

class App
{
    public function run()
    {
        //Для паттерна НАБЛЮДАТЕЛЬ
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


        //Что нужно приготовить? Паттерн СТРАТЕГИЯ и привязка к НАБЛЮДАТЕЛЮ (делаем привязку ObserverMailer к Product)
        foreach ($order as $item) {
            $products[] = (new Cook())->Prepare($item[0], $item[1])->attach($observer);
        }

        //Проверить еду на соответствие стандарту. Паттерн ПРОКСИ
        foreach ($products as $i=>$product) {
            if (!(new TasterProducts($product))->standardsCompliance()) {
                unset($products[$i]);
                throw new \DomainException('Приготовили что то не то!');
            } else {
                $product->changeReadyStatus(Product::READY_STATUS);
            }
        }
    }


    public static function getConfig()
    {
        if (!file_exists('/data/mysite.local/src/Config/config.php')) {
            return false;
        } else {
            return include('Config/config.php');
        }
    }
}
