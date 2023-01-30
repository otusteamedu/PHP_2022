<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\Contracts;

interface Recipe
{
    /**
     * @return array
     */
    public function get(): array;
}
