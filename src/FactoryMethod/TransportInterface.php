<?php

namespace Patterns\FactoryMethod;

interface TransportInterface
{
    public function load(): string;

    public function deliver(string $cargo): string;

    public function unload(): string;
}
