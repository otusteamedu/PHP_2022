<?php

declare(strict_types=1);

namespace App\Infractructure\Request;

/**
 * ClientRequest
 */
class ClientRequest implements RequestInterface
{
    /**
     * @var array|string[]
     */
    private array $ingredients = ["Sugar"];

    /**
     * @return array|string[]
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}