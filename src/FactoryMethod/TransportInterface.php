<?php

namespace Patterns\FactoryMethod;

interface TransportInterface
{
    public function load(): void;

    public function deliver(string $cargo): void;

    public function unload(): void;
}
