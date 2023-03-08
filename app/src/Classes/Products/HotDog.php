<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Products;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\HotDogInterface;

class HotDog implements HotDogInterface
{
    public NotifierInterface $notifier;
    public array $ingredients = ['булочки', 'сосиска', 'кетчуп', 'салат'];

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
