<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity;


class Recipe implements EntityInterface, RecipeInterface
{
    public function __construct(
        public string $name,
        public array $ingredients
    ) {
    }
}