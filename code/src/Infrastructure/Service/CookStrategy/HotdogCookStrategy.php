<?php


namespace Study\Cinema\Infrastructure\Service\CookStrategy;

use Study\Cinema\Domain\Entity\Hotdog;
use Study\Cinema\Domain\Interface\CookStrategyInterface;
use Study\Cinema\Domain\Interface\FoodBuilder;
use Study\Cinema\Infrastructure\Food;
use Study\Cinema\Infrastructure\Service\Builder\HotdogBuider;

class HotdogCookStrategy implements CookStrategyInterface
{
    private Hotdog $hotdog;
    private HotdogBuider $builder;

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
        if(isset($data['tomato_sauce']))
            $this->builder->setTomatoSauce($data['tomato_sauce']);

        $this->hotdog = $this->builder->build();

        $this->hotdog->setBase($data['base']);
        $this->hotdog->setSausage($data['sausage']);

        return $this->hotdog;

    }
    private function validate($data){

        if(empty($data['base'])){
            throw new ArgumentException("Нет параметра base ");
        }
        if(empty($data['sausage'])){
            throw new ArgumentException("Нет параметра sausage ");
        }

    }

}