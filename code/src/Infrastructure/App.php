<?php

namespace Study\Cinema\Infrastructure;

use Study\Cinema\Infrastructure\Service\Builder\BurgerBuider;
use Study\Cinema\Infrastructure\Service\Builder\HotdogBuider;
use Study\Cinema\Infrastructure\Service\FoodFactory\BurgerFactory;
use Study\Cinema\Infrastructure\Service\FoodFactory\HotdogFactory;
use Study\Cinema\Infrastructure\Service\CookStrategy\HotdogCookStrategy;
use Study\Cinema\Infrastructure\Service\CookStrategy\BurgerCookStrategy;
use Study\Cinema\Domain\Interface\FoodFactoryInterface;


class App
{
    public function __construct()
    {
    }
    public function run()
    {

        $burgerFactory = new BurgerFactory();
        $hotdogFactory = new HotdogFactory();

        $type = $_POST['type'];
        //$size = $_POST['size'];

        $strategy = null;
        if($type == FoodFactoryInterface::TYPE_BURGER )
        {
            $food = $burgerFactory->make();
            $builder  = new BurgerBuider($food);
            $strategy = new BurgerCookStrategy($builder);

        }else{

            $food = $hotdogFactory->make();
            $builder = new HotdogBuider($food);
            $strategy = new HotdogCookStrategy($builder);
        }
        $cookService = new CookService($strategy);

       $food =  $cookService->cook($_POST);
       print $food->__toString();



    }

}
