<?php


namespace Study\Cinema\Infrastructure\Service\CookStrategy;


use Study\Cinema\Domain\Entity\Burger;
use Study\Cinema\Domain\Interface\FoodBuilder;
use Study\Cinema\Infrastructure\Exception\ArgumentException;
use Study\Cinema\Domain\Interface\CookStrategyInterface;
use Study\Cinema\Infrastructure\Food;
use Study\Cinema\Infrastructure\Service\Builder\BurgerBuider;
use Study\Cinema\Infrastructure\Service\EventManager\EventManager;

class BurgerCookStrategy implements  CookStrategyInterface
{
   private Burger $burger;
   private BurgerBuider $builder;
   private EventManager $eventManager;

   public function __construct(FoodBuilder $builder, EventManager $eventManager)
   {
        $this->builder = $builder;
        $this->eventManager = $eventManager;
   }

   public function cook(array $data) : Food
   {
        // TODO: Implement cook() method.
        $this->validate($data);

        $this->eventManager->notify("order", "Заказ получен.");
        if(isset($data['tomato']))
            $this->builder->setTomato($data['tomato']);
       if(isset($data['onion']))
            $this->builder->setOnion($data['onion']);

        $this->burger = $this->builder->build();

        $this->burger->setBase($data['base']);
        $this->burger->setCutlet($data['cutlet']);
        $this->burger->setState(Food::FOOD_STATE_BURNT);

       $this->eventManager->notify("order", "Заказ приготвлен и отправлен на сборку.");
       return $this->burger;

   }
   private function validate($data){

       if(empty($data['base'])){
           throw new ArgumentException("Нет параметра base ");
       }
       if(empty($data['cutlet'])){
           throw new ArgumentException("Нет параметра cutlet ");
       }

   }

}