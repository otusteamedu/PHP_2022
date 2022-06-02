<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Service\Decorator;


use Decole\Hw18\Domain\Entity\InnerProduct;
use Decole\Hw18\Domain\Entity\Product\ProductInterface;
use Decole\Hw18\Domain\Repository\RecipeRepository;
use Decole\Hw18\Domain\Service\Prototype\InnerProductPrototype;

class RecipeDecorator implements ComponentInterface
{
    private ?string $recipe;

    public function __construct($component)
    {
        $this->recipe = $component;
    }

    public function joinToBaseProduct(ProductInterface $baseProduct): ProductInterface
    {
        if ($this->recipe === null) {
            return $baseProduct;
        }

        // recipe::Стандарт
        $concreteRecipe = explode('::', $this->recipe);
        $repository = new RecipeRepository();
        $selectedRecipe = $repository->getByName($concreteRecipe[1]);

        if ($selectedRecipe === null) {
            return $baseProduct;
        }

        /** @var InnerProduct $ingredient */
        foreach ($selectedRecipe->ingredients as $ingredient) {
            $prototype = new InnerProductPrototype();
            $prototype->name = $ingredient->name;
            $prototype->type = $ingredient->type;
            $prototype->amountType = $ingredient->amountType;
            $prototype->amount = $ingredient->amount;

            $baseProduct->join(clone $prototype);
        }

        return $baseProduct;
    }
}