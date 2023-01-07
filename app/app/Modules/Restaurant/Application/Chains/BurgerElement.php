<?php

declare(strict_types=1);

namespace App\Modules\Restaurant\Application\Chains;

use App\Modules\Restaurant\Domain\Repositories\IngredientsRepositoryInterface;

abstract class BurgerElement
{
    private ?BurgerElement $nextElement;

    public function __construct(?BurgerElement $nextElement = null)
    {
        $this->nextElement = $nextElement;
    }

    public function setNext(BurgerElement $burgerElement): BurgerElement
    {
        $this->nextElement = $burgerElement;

        return $burgerElement;
    }

    public function handle(IngredientsRepositoryInterface $repository)
    {
        if ($this->nextElement !== null) {
            $this->nextElement->handle($repository);
        }
    }
}
