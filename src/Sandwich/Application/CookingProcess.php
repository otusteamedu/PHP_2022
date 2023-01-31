<?php

declare(strict_types=1);

namespace Src\Sandwich\Application;

use DI\Container;
use Src\Sandwich\Domain\Contracts\BasicProduct;
use Src\Sandwich\DTO\SandwichParametersDTO;
use Src\Sandwich\Domain\UseCases\BasicProductFactory;
use Src\Sandwich\Domain\UseCases\CookingContextStrategy;
use Src\Sandwich\Domain\Contracts\Events\CookingTraceability;

class CookingProcess
{
    /**
     * @var BasicProduct
     */
    protected BasicProduct $cooked_basic_product;

    /**
     * @var CookingTraceability
     */
    protected CookingTraceability $cooking_observer;

    /**
     * @var CookingContextStrategy
     */
    private CookingContextStrategy $cooking_strategy;

    /**
     * @var BasicProductFactory
     */
    private BasicProductFactory $sandwich_factory;

    /**
     * @param Container $di_container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $di_container)
    {
        $this->cooking_strategy = $di_container->get(name: CookingContextStrategy::class);
        $this->cooking_observer = $di_container->get(name: CookingTraceability::class);
        $this->sandwich_factory = $di_container->get(name: BasicProductFactory::class);
    }

    /**
     * @param SandwichParametersDTO $sandwich_parameters_dto
     * @return $this
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function startCooking(SandwichParametersDTO $sandwich_parameters_dto): self
    {
        $recipe = $this->cooking_strategy->getWhatToCook(sandwich_parameters_dto: $sandwich_parameters_dto);

        $basic_product = $this->sandwich_factory->prepareBasicProduct(
            sandwich_parameters_dto: $sandwich_parameters_dto,
            product_recipe: $recipe
        );

        $this->cooking_observer->subscribe(basic_product: $basic_product);

        $this->cooked_basic_product = $basic_product->cook();

        return $this;
    }

    /**
     * @return BasicProduct
     */
    public function getResult(): BasicProduct
    {
        $this->cooking_observer->notifySubscribers(event_name: 'IsReady');

        return $this->cooked_basic_product;
    }
}
