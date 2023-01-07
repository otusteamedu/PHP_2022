<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application\Chains;

use App\Modules\Restaurant\Domain\Repositories\IngredientsRepositoryInterface;

class Chain
{
    private BurgerElement $firstElement;

    public function __construct(BurgerElement $element)
    {
        $this->firstElement = $element;
    }

    public function checkIngredients(IngredientsRepositoryInterface $repository): void
    {
        $this->firstElement->handle($repository);
    }
}
