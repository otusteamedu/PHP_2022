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
    private BasicProduct $basic_product;

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
        return $this->sandwich_parameters_dto->sandwich_prototype;
    }

    /**
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function cook(): array
    {
        return array_merge(
            $this->basic_product->cook(),
            $this->addIngredients(),
        );
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function addIngredients(): array
    {
        $merged_ingredients = array_merge(
            $this->product_recipe->get(),
            $this->sandwich_parameters_dto->sandwich_partials
        );

        $ready_ingredients = [];

        foreach ($merged_ingredients as $ingredient => $ingredient_quantity) {
            $ingredient = $this->di_container->make(name: $ingredient . 'Ingredient');

            $ingredient->setQuantity(quantity: $ingredient_quantity);

            $ready_ingredients[] = $ingredient;
        }

        return $ready_ingredients;
    }
}
