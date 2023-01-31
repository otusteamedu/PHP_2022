<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\UseCases\Cooking;

use DI\Container;
use Src\Sandwich\Domain\Contracts\Recipe;
use Src\Sandwich\DTO\SandwichParametersDTO;
use Src\Sandwich\Domain\Contracts\BasicProduct;

final class HotDogDecorator implements BasicProduct
{
    /**
     * @var BasicProduct
     */
    public BasicProduct $basic_product;

    /**
     * @var array
     */
    public array $ingredients;

    /**
     * @var SandwichParametersDTO
     */
    private SandwichParametersDTO $sandwich_parameters_dto;

    /**
     * @var Recipe
     */
    private Recipe $product_recipe;

    /**
     * @var Container
     */
    private Container $di_container;

    /**
     * @param SandwichParametersDTO $sandwich_parameters_dto
     * @param BasicProduct $basic_product
     * @param Recipe $product_recipe
     * @param Container $di_container
     */
    public function __construct(
        SandwichParametersDTO $sandwich_parameters_dto,
        BasicProduct $basic_product,
        Recipe $product_recipe,
        Container $di_container
    ) {
        $this->sandwich_parameters_dto = $sandwich_parameters_dto;
        $this->basic_product = $basic_product;
        $this->product_recipe = $product_recipe;
        $this->di_container = $di_container;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->basic_product . '';
    }

    /**
     * @return BasicProduct
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function cook(): BasicProduct
    {
        $this->addIngredients();

        return $this;
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function addIngredients(): void
    {
        $merged_ingredients = array_merge(
            $this->product_recipe->get(),
            $this->sandwich_parameters_dto->sandwich_partials
        );

        foreach ($merged_ingredients as $ingredient => $ingredient_quantity) {
            $ingredient = $this->di_container->make(name: $ingredient . 'Ingredient');

            $ingredient->setQuantity(quantity: $ingredient_quantity);

            $this->ingredients[] = $ingredient;
        }
    }
}
