<?php

namespace Mselyatin\Patterns\domain\valueObjects\sauces;

use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;
use Mselyatin\Patterns\domain\interfaces\factories\FactoryMethodInterface;

class KetchupValueObject implements CompositionBakeryItemInterface, FactoryMethodInterface
{
    public function getName(): string
    {
        return 'ketchup';
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