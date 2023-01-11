<?php


namespace Study\Cinema\Domain\Entity;


use Study\Cinema\Domain\Interface\EventListener;
use Study\Cinema\Infrastructure\Food;

class OrderControl implements OrderInterface
{
    private Order $order;
    private QualityControl $qualityControl;

    public function __construct(Order $order, QualityControl $qualityControl)
    {
        $this->order = $order;
        $this->qualityControl = $qualityControl;
    }
    public function sendToDelivery(Food $food): bool
    {
        if(!$this->check($food)){

            $this->qualityControl->update("Заказ не соответвует качеству. Утилизировать!");
            return false;
        }
        else
            return $this->order->sendToDelivery($food);


    }
    private function check(Food $food) : bool
    {
        if($food->getState() == Food::FOOD_STATE_OK)
            return true;
        return false;
    }

}