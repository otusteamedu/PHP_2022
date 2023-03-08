<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Products;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\SandwichInterface;

class Sandwich implements SandwichInterface
{
    public NotifierInterface $notifier;
    public array $ingredients = ['салат', 'лук', 'перец', 'булочка'];

    public function __construct(NotifierInterface $notifier)
    {
        $this->notifier = $notifier;
    }

    public function make(): static
    {
        $preparedProduct = $this->getPreparedProduct();
        $this->notifier->notify();

        return $preparedProduct;
    }

    public function getPreparedProduct(): static
    {
        return $this;
    }
}
