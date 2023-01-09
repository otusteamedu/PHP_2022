<?php


namespace Study\Cinema\Infrastructure\Service\CookStrategy;


use Study\Cinema\Domain\Entity\Burger;
use Study\Cinema\Domain\Interface\FoodBuilder;
use Study\Cinema\Infrastructure\Exception\ArgumentException;
use Study\Cinema\Domain\Interface\CookStrategyInterface;
use Study\Cinema\Infrastructure\Food;
use Study\Cinema\Infrastructure\Service\Builder\BurgerBuider;

class BurgerCookStrategy implements  CookStrategyInterface
{
   private Burger $burger;
   private BurgerBuider $builder;

   public function __construct(FoodBuilder $builder)
   {
        $this->builder = $builder;
   }

   public function cook(array $data) : Food
   {
        // TODO: Implement cook() method.
        $this->validate($data);

        if(isset($data['tomato']))
            $this->builder->setTomato($data['tomato']);
       if(isset($data['onion']))
            $this->builder->setOnion($data['onion']);

        $this->burger = $this->builder->build();

        $this->burger->setBase($data['base']);
        $this->burger->setCutlet($data['cutlet']);

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