<?php

namespace Mselyatin\Patterns\domain\valueObjects\bakery;

use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;
use Mselyatin\Patterns\domain\interfaces\factories\FactoryMethodInterface;

class BunValueObject implements CompositionBakeryItemInterface, FactoryMethodInterface
{
    public function getName(): string
    {
        return 'bun';
    }

    public static function make(array $config = []): self
    {
        return new self();
    }
}