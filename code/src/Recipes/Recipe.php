<?php

namespace Ppro\Hw20\Recipes;

use Ppro\Hw20\Actions\CookAction;
use Ppro\Hw20\Actions\Prepare;
use Ppro\Hw20\Entity\IngredientsDto;
use Ppro\Hw20\Products\ProductFactoryInterface;

class Recipe implements RecipeStrategyInterface
{
    /**
     * @var IngredientsDto
     */
    private IngredientsDto $ingredients;

    /**
     * @param ProductFactoryInterface $productFactory
     * @param array $recipeSteps
     * @param array $orderSets
     */
    public function __construct(private ProductFactoryInterface $productFactory, private array $recipeSteps, private array $orderSets = [])
    {
        array_walk($this->recipeSteps,function(&$step){$step = explode(",",$step);});
        $this->ingredients = new IngredientsDto();
        $this->ingredients->setIngredients($this->getIngredientsArray());
    }

    /**
     * @return ProductFactoryInterface
     */
    public function getProductFactory(): ProductFactoryInterface
    {
        return $this->productFactory;
    }

    /**
     * @return IngredientsDto
     */
    public function getIngredients(): IngredientsDto
    {
        return $this->ingredients;
    }

    /**
     * @return array
     */
    public function getIngredientsArray(): array
    {
        return array_map(fn($item):string => reset($item),$this->getRecipeByStep());
    }

    /**
     * @return array
     */
    private function getRecipeByStep()
    {
        return array_filter($this->recipeSteps,fn($recipeItem)=>!in_array(reset($recipeItem),$this->orderSets));
    }

    /** Формирование цепочки обязанностей (последовательность приготовления)
     * @return CookAction
     */
    public function getProcess(): CookAction
    {
        $firstHandler = new Prepare($this->getIngredientsArray());
        $process = $this->getRecipeByStep();
        array_reduce($process,function($currentHandler,$processItem){
            list($ingredient,$action) = $processItem;
            return $currentHandler->setNextAction(new $action([$ingredient]));
        },$firstHandler);
        return $firstHandler;
    }
}