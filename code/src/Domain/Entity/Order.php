<?php


namespace Study\Cinema\Domain\Entity;


use Study\Cinema\Domain\Interface\EventListener;
use Study\Cinema\Infrastructure\Food;

class Order implements OrderInterface, EventListener
{
    /**
     * Слушает состояние заказа
     * @param string $status
     */
    public function update(string $status){
        echo " -- Статус изменен. --".PHP_EOL. $status .PHP_EOL;
    }

    public function sendToDelivery(Food $food) : bool
    {
        echo "Все хорошо! Отправляем в доставку!";
        return true;
    }
}