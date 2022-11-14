<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Dto;

class DishDto
{
    public ?string $dish = null;
    public ?string $recipe = null;
    public array $ingredients = [];
}