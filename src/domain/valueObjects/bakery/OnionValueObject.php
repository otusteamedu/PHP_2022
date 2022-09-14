<?php

namespace Mselyatin\Patterns\domain\valueObjects\bakery;

use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;
use Mselyatin\Patterns\domain\interfaces\factories\FactoryMethodInterface;

class OnionValueObject implements CompositionBakeryItemInterface, FactoryMethodInterface
{
    public function getName(): string
    {
        return 'onion';
    }

    /**
     * @param array $config
     * @return static
     */
    public static function make(array $config = []): self
    {
        return new self();
    }
}