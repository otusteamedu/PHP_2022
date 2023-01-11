<?php

namespace Study\Cinema\Infrastructure;


use Study\Cinema\Domain\Entity\Order;
use Study\Cinema\Domain\Entity\OrderControl;
use Study\Cinema\Domain\Entity\QualityControl;
use Study\Cinema\Infrastructure\Service\Builder\BurgerBuider;
use Study\Cinema\Infrastructure\Service\Builder\HotdogBuider;
use Study\Cinema\Infrastructure\Service\FoodFactory\BurgerFactory;
use Study\Cinema\Infrastructure\Service\FoodFactory\HotdogFactory;
use Study\Cinema\Infrastructure\Service\CookStrategy\HotdogCookStrategy;
use Study\Cinema\Infrastructure\Service\CookStrategy\BurgerCookStrategy;
use Study\Cinema\Domain\Interface\FoodFactoryInterface;
use Study\Cinema\Infrastructure\Service\EventManager\EventManager;


class App
{
    public function __construct()
    {
    }
    public function run()
    {

        $burgerFactory = new BurgerFactory();
        $hotdogFactory = new HotdogFactory();

        $qualityControl = new QualityControl();
        $order = new Order();
        $orderProxy = new OrderControl($order, $qualityControl);


        $eventManager = new EventManager();
        $eventManager->subscribe("order", $order);
        $eventManager->subscribe("quality", $qualityControl);

        $type = $_POST['type'];
        //$size = $_POST['size'];

        $strategy = null;
        if($type == FoodFactoryInterface::TYPE_BURGER )
        {
            $food = $burgerFactory->make();
            $builder  = new BurgerBuider($food);
            $strategy = new BurgerCookStrategy($builder, $eventManager);

        }else{

            $food = $hotdogFactory->make();
            $builder = new HotdogBuider($food);
            $strategy = new HotdogCookStrategy($builder, $eventManager);
        }
        $cookService = new CookService($strategy, $orderProxy);
        $food =  $cookService->cook($_POST);

        if(is_null($food)){
            echo "Не смогли приготовить";
        }
        else
            echo $food;




    }

}
