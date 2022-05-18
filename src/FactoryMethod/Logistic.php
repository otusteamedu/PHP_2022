<?php

namespace Patterns\FactoryMethod;

abstract class Logistic
{
    abstract public function getTransport(): TransportInterface;

    public function deliverCargo(string $cargoName): void
    {
        $transport = $this->getTransport();
        $transport->load();
        $transport->deliver($cargoName);
        $transport->unload();
    }
}
