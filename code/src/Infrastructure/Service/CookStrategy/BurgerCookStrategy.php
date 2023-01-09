<?php


namespace Study\Cinema\Infrastructure\Service\CookStrategy;


use Study\Cinema\Domain\Entity\Burger;
use Study\Cinema\Infrastructure\Exception\ArgumentException;
use Study\Cinema\Domain\Interface\CookStrategyInterface;
use Study\Cinema\Infrastructure\Food;

class BurgerCookStrategy implements  CookStrategyInterface
{
   private Burger $burger;

   public function __construct(Food $burger)
   {
        $this->burger = $burger;
   }

   public function cook(array $data) : Food
   {
        // TODO: Implement cook() method.
        $this->validate($data);

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