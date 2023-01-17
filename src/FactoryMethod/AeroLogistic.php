<?php

namespace Patterns\FactoryMethod;

class AeroLogistic extends Logistic
{
    public function getTransport(): TransportInterface
    {
        return new Aero();
    }
}
