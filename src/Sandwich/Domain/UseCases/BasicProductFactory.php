<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\UseCases;

use DI\Container;
use Src\Sandwich\DTO\SandwichParametersDTO;
use Src\Sandwich\Domain\Contracts\{BasicProduct, Recipe};

final class BasicProductFactory
{
    /**
     * @var Container
     */
    private Container $di_container;

    /**
     * @param Container $di_container
     */
    public function __construct(Container $di_container)
    {
        $this->di_container = $di_container;
    }

    /**
     * @param SandwichParametersDTO $sandwich_parameters_dto
     * @param Recipe $product_recipe
     * @return BasicProduct
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function prepareBasicProduct(
        SandwichParametersDTO $sandwich_parameters_dto,
        Recipe $product_recipe
    ): BasicProduct {
        $basic_product = $this->di_container
            ->make(
                name: $sandwich_parameters_dto->sandwich_prototype,
                parameters: [
                    'basic_product_name' => $sandwich_parameters_dto->sandwich_prototype
                ]
            );

        return $this->di_container
            ->make(
                name: $sandwich_parameters_dto->sandwich_prototype . 'Decorator',
                parameters: [
                    'sandwich_parameters_dto' => $sandwich_parameters_dto,
                    'basic_product' => $basic_product,
                    'product_recipe' => $product_recipe,
                ]
            );
    }
}
