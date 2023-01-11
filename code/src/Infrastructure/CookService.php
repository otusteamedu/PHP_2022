<?php


namespace Study\Cinema\Infrastructure;

use Study\Cinema\Domain\Entity\OrderInterface;
use Study\Cinema\Domain\Interface\CookStrategyInterface;

class CookService
{
    private CookStrategyInterface $strategy;
    private $order;

    public function __construct(CookStrategyInterface $cookStrategy, OrderInterface $order)
    {
        $this->strategy = $cookStrategy;
        $this->order = $order;
    }

    public function cook($data) {

        $readyFood =  $this->strategy->cook($data);
        if($this->order->sendToDelivery($readyFood))
            return $readyFood;
        return null;

    }

}