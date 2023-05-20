<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO;

class Ingredients
{
    private array $ingredients;

    /**
     * @param array $ingredients
     */
    public function __construct(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->ingredients;
    }

    /**
     * @param array $ingredients
     * @return Ingredients
     */
    public function set(array $ingredients): Ingredients
    {
        $this->ingredients = $ingredients;
        return $this;
    }
}