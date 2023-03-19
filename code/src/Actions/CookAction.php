<?php

namespace Ppro\Hw20\Actions;

use Ppro\Hw20\Products\ProductInterface;
use Ppro\Hw20\Recipes\RecipeStrategyInterface;

abstract class CookAction
{
    public function __construct(protected ?array $ingredient = null,protected ?RecipeStrategyInterface $recipe = null, private ?CookAction $nextAction = null)
    {
    }

    public function setNextAction(CookAction $action): CookAction
    {
        $this->nextAction = $action;
        return $action;
    }

    public function handle(ProductInterface $product): void
    {
        if ($this->nextAction !== null) {
            $this->nextAction->handle($product);
        }
    }
}