<?php


namespace Study\Cinema\Infrastructure;

use Study\Cinema\Domain\Interface\CookStrategyInterface;

class CookService
{
    private $strategy;

    public function __construct(CookStrategyInterface $cookStrategy)
    {
        $this->strategy = $cookStrategy;
    }

    public function cook($data){

        return $this->strategy->cook($data);
    }

}