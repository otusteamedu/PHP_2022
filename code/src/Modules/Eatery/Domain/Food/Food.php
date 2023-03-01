<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Food;

class Food
{
    private string $name;
    private array $recipe;

    /**
     * @param string $name
     * @param array $recipe
     */
    public function __construct(string $name, array $recipe)
    {
        $this->name = $name;
        $this->recipe = $recipe;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Food
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getRecipe(): array
    {
        return $this->recipe;
    }

    /**
     * @param array $recipe
     * @return Food
     */
    public function setRecipe(array $recipe): self
    {
        $this->recipe = $recipe;
        return $this;
    }
}