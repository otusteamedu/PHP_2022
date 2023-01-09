<?php


namespace Study\Cinema\Infrastructure\Service\CookStrategy;

use Study\Cinema\Domain\Entity\Hotdog;
use Study\Cinema\Domain\Interface\CookStrategyInterface;
use Study\Cinema\Infrastructure\Food;

class HotdogCookStrategy implements CookStrategyInterface
{
    private Hotdog $hotdog;

    public function __construct(Food $hotdog)
    {
        $this->hotdog = $hotdog;
    }
    public function cook(array $data) : Food
    {
        // TODO: Implement cook() method.
        $this->validate($data);

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