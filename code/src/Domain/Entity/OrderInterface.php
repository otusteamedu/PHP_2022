<?php


namespace Study\Cinema\Domain\Entity;


use Study\Cinema\Infrastructure\Food;

interface OrderInterface
{

    public function sendToDelivery(Food $food): bool;

}