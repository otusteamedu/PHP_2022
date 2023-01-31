<?php

declare(strict_types=1);

namespace Src\Sandwich\Domain\UseCases;

use DI\Container;
use Src\Sandwich\Domain\Contracts\Recipe;
use Src\Sandwich\DTO\SandwichParametersDTO;

final class CookingContextStrategy
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
     * @return Recipe
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function getWhatToCook(SandwichParametersDTO $sandwich_parameters_dto): Recipe
    {
        return $this->di_container->get(name: $sandwich_parameters_dto->sandwich_prototype . 'Recipe');
    }
}
