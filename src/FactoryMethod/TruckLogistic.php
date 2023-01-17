<?php

namespace Patterns\FactoryMethod;

class TruckLogistic extends Logistic
{
    public function getTransport(): TransportInterface
    {
        return new Truck();
    }
}
